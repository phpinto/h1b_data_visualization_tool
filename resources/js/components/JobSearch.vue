<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>H-1B Job List:</h3>
                <div class="card-body">
                    <form @submit.prevent="submit"  class="form-horizontal" id="search-form" method="POST">
                    <div class="form-group row">
                        <div class="col">
                        <input type="text" class="form-control" placeholder="Job Title" name="job_title" id="job_title" v-model="fields.job_title">
                        </div>
                        <div class="col">
                        <input type="text" class="form-control" placeholder="Employer" name="employer" id="employer" v-model="fields.employer"> 
                        </div>
                        <div class="col">
                        <input type="text" class="form-control" placeholder="City" name="city" id="city" v-model="fields.city">
                        </div>
                        <div class="col">
                        <select class="form-control" name="state" id="state" v-model="fields.state">
                            <option selected>{{ fields.state }}</option>
                            <option value="State" selected v-if="fields.state != 'State'">State</option>
                            <option v-for="state in states" v-bind:key="state">{{ state }}</option>
                        </select>                
                        </div>
                        <div class="col">
                        <select class="form-control" name="year" id="year" v-model="fields.year">
                            <option selected>{{ fields.year }}</option>
                            <option value="Year" selected v-if="fields.year != 'Year'">Year</option>
                            <option v-for="year in years" v-bind:key="year">{{ year }}</option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group row">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary float-right">
                            Search
                        </button>
                    </div>
                </div>
            </form>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">Job Title</th>
                            <th scope="col">Employer</th>
                            <th scope="col">City</th>
                            <th scope="col">State</th>
                            <th scope="col">Salary</th>
                            <th scope="col">Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="job in jobs" v-bind:key="job.id">
                            <td>{{ job.job_title }}</td>
                            <td>{{ job.employer }}</td>
                            <td>{{ job.city }}</td>
                            <td>{{ job.state }}</td>
                            <td>${{ Math.trunc(job.salary).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                            <td>{{ job.year }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <center v-if="loaded == false">
                        <clip-loader :color="color"></clip-loader>
                        <strong>Loading</strong>
                    </center>
                    <nav aria-label="Page navigation e ample" v-if="job_count > 15">
                        <ul class="pagination">
                            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchJobs(pagination.prev_page_url)">Previous</a></li>
                            <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                            <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchJobs(pagination.next_page_url)">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
    data () {
        return {
            jobs: [],
            fields: {
                state: "State",
                year: "Year",
                job_title: "",
                employer: "",
                city: "",
            },
            years: [
                2011,
                2012,
                2013,
                2014,
                2015,
                2016,
                2017
            ],
            states: [
                "Alabama",
                "Alaska",
                "Arizona",
                "Arkansas",
                "California",
                "Colorado",
                "Connecticut",
                "Delaware",
                "District Of Columbia",
                "Florida",
                "Georgia",
                "Hawaii",
                "Idaho",
                "Illinois",
                "Indiana",
                "Iowa",
                "Kansas",
                "Kentucky",
                "Louisiana",
                "Maine",
                "Maryland",
                "Massachusetts",
                "Michigan",
                "Minnesota",
                "Mississippi",
                "Missouri",
                "Montana",
                "Nebraska",
                "Nevada",
                "New Hampshire",
                "New Jersey",
                "New Mexico",
                "New York",
                "North Carolina",
                "North Dakota",
                "Ohio",
                "Oklahoma",
                "Oregon",
                "Pennsylvania",
                "Puerto Rico",
                "Rhode Island",
                "South Carolina",
                "South Dakota",
                "Tennessee",
                "Texas",
                "Utah",
                "Vermont",
                "Virginia",
                "Washington",
                "West Virginia",
                "Wisconsin",
                "Wyoming"
            ],
            loaded: false,
            color: '#428bca',
            pagination: {},
            job_count: 0,
            window: {
                width: 2000,
                height: 2000
            }
        };
    },

    created() {
        this.fetchJobs();
        window.addEventListener('resize', this.handleResize)
        this.handleResize();
    },

    destroyed() {
        window.removeEventListener('resize', this.handleResize)
    },

    methods: {
        fetchJobs(page_url) {
            if (this.fields.job_title == "") this.fields.job_title = "*****";
            if (this.fields.employer == "") this.fields.employer = "*****";
            if (this.fields.city == "") this.fields.city = "*****";
            if (this.fields.state == "State") this.fields.state = "*****";
            if (this.fields.year == "Year") this.fields.year = "*****";
            page_url = page_url || ('/getJobs/' + this.fields.job_title + '/' + this.fields.employer + '/' + this.fields.city + '/' + this.fields.state + '/' + this.fields.year);
            this.loaded = false;
            this.jobs = [];
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    if (this.fields.job_title == "*****") this.fields.job_title = ""
                    if (this.fields.employer == "*****") this.fields.employer = ""
                    if (this.fields.city == "*****") this.fields.city = ""
                    if (this.fields.state == "*****") this.fields.state = "State"
                    if (this.fields.year == "*****") this.fields.year = "Year"
                    this.loaded = true;
                    this.jobs = res.data;
                    this.job_count = res.meta.total;
                    this.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));
        },
        handleResize() {
            this.window.width = window.innerWidth;
            this.window.height = window.innerHeight;
        },
        makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };
                this.pagination = pagination;
        },

        
        submit() {
            this.fetchJobs();
        },
    }
    }
</script>
