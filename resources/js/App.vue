<template>
  <div class="navbar-wrapper">
    <div class="container">
      <nav class="navbar">
        <a class="navbar-brand" href="#">
          <img src="img/Netwrix_logo_120x25.png" alt="Netwrix" />
        </a>
      </nav>
    </div>
  </div>
  <!-- /NAVBAR -->

  <div class="hero">
    <div class="hero-content container-sm">
      <h1>Netwrix Partner Locator</h1>
      <div class="hero-info">
        <p>
          Hundreds of Netwrix partners around the world are standing by to help
          you.
        </p>
        <p>
          With our Partner Locator you can easily find the list of authorized
          partners in your area.
        </p>
      </div>
      <form class="filter-partners-form" @submit.prevent="searchPartners">
        <div class="mb-3 search-wrapper">
          <label for="search" class="visually-hidden">Search</label>
          <input
            type="text"
            class="form-control form-control-lg"
            id="search"
            v-model="formData.search"
            :placeholder="searchText"
            v-on:keyup.enter="searchPartners"
          />
          <button class="icon-button search-submit" type="submit">
            <font-awesome-icon icon="fa-solid fa-magnifying-glass" />
          </button>
        </div>
        <div class="mb-3 row">
          <div class="col-md-4">
            <Select2
              class="form-control hero-filter"
              v-model="formData.status"
              :options="StatusOptions"
              :settings="StatusSelectSettings"
              v-on:keyup.enter="searchPartners"
            />
          </div>
          <div class="col-md-8">
            <div class="input-group">
              <Select2
                class="form-control hero-filter"
                v-model="formData.country"
                :options="CountryOptions"
                :settings="CountrySelectSettings"
                @select="CountryChangeEvent($event)"
                v-on:keyup.enter="searchPartners"
              />
              <Select2
                class="form-control hero-filter"
                v-model="formData.state"
                :options="StateOptions"
                :settings="StateSelectSettings"
                v-on:keyup.enter="searchPartners"
              />
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- /HERO -->

  <div class="partners">
    <div class="container">
      <div class="partner" v-for="partner in partners" :key="partner.id">
        <div class="row">
          <div class="partner-logo-container col-lg-2 col-md-3">
            <figure>
              <img class="partner-logo" :src="partner.logo" width="97" height="77" />
            </figure>
          </div>
          <div class="partner-info-container col-lg-6 col-md-6">
            <h2 class="partner-title">{{ partner.company }}</h2>
            <div class="partner-address">{{ partner.address }}</div>
          </div>
          <div class="partner-meta-container col-lg-4 col-md-3">
            <div class="row">
              <div class="partner-contacts col-md-6">
                <div class="partner-website">
                  <a :href="partner.website" target="_blank" rel="nofollow"
                    >Website</a
                  >
                </div>
                <div class="partner-phone">{{ partner.phone }}</div>
              </div>
              <div class="partner-status-container col-md-6">
                <div class="partner-status">{{ partner.status }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="loading" v-if="isLoading">
      <div class="lds-ellipsis">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
      </div>
      <div>Loading...</div>
    </div>
    <div class="nothing-found" v-if="showNothingFound">
      Your search parameters did not match any partners. Please try different
      search.
    </div>
  </div>
  <!-- /PARTNERS -->
</template>
<script>
export default {
  name: "app-component",
  data() {
    return {
      CountryOptions: [],
      CountrySelectSettings: {
        placeholder: "Country",
        width: "100%",
        selectionCssClass: "form-select",
      },
      StateOptions: [],
      StateSelectSettings: {
        placeholder: "State",
        width: "100%",
        selectionCssClass: "form-select",
      },
      StatusOptions: [
        "Preferred Partner",
        "MSP Partner",
        "Premium Partner",
        "Distributor",
        "Elite Partner",
      ],
      StatusSelectSettings: {
        placeholder: "Status",
        width: "100%",
        selectionCssClass: "form-select",
      },
      partners: [],
      formData: {
        search: null,
        status: null,
        country: null,
        state: null,
      },
      isLoading: false,
      refCount: 0,
      showNothingFound: false,
      searchText: 'Search by company name or address'
    };
  },
  created() {
    window.countries.forEach((country) => {
      this.CountryOptions.push({
        id: country.country_id,
        text: country.name,
      });
    });
    window.states.forEach((state) => {
      this.StateOptions.push({
        id: state.state_id,
        text: state.name,
      });
    });
    this.axios
      .get(process.env.MIX_APP_URL + "/api/partners", {
        params: {
          collection: 1,
        },
      })
      .then((response) => {
        this.partners = response.data.data;
      });
    this.axios.interceptors.request.use(
      (config) => {
        this.setLoading(true);
        return config;
      },
      (error) => {
        this.setLoading(false);
        return Promise.reject(error);
      }
    );

    this.axios.interceptors.response.use(
      (response) => {
        this.setLoading(false);
        return response;
      },
      (error) => {
        this.setLoading(false);
        return Promise.reject(error);
      }
    );

    window.addEventListener("resize", this.handleResize);
    this.handleResize();
  },
  methods: {
    searchPartners() {
      if (Object.values(this.formData).some((x) => x !== null && x !== "")) {
        this.axios
          .get(process.env.MIX_APP_URL + "/api/partners", {
            params: this.formData,
          })
          .then((response) => {
            this.partners = response.data;
            if (this.partners.length > 0) {
              this.showNothingFound = false;
            } else {
              this.showNothingFound = true;
            }
          });
      }
    },
    setLoading(isLoading) {
      if (isLoading) {
        this.refCount++;
        this.isLoading = true;
        document
          .querySelector(".partners")
          .scrollIntoView({ behavior: "smooth", block: "start" });
      } else if (this.refCount > 0) {
        this.refCount--;
        this.isLoading = this.refCount > 0;
      }
    },
    handleResize() {
      if(window.innerWidth < 768){
        this.searchText = 'search';
      }else{
        this.searchText = 'Search by company name or address';
      }
    },
  },
};
</script>
