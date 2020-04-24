<template>
        <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Top Companies:</h3>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">Rank</th>
                            <th scope="col">Employer</th>
                            <th scope="col">Average Salary</th>
                            <th scope="col">Average # of Filings</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="employer in employers" v-bind:key="employer.employer">
                                <td>{{ employer.id }}</td>
                                <td>{{ employer.employer }}</td>
                                <td>${{ Math.trunc(employer.avg_salary).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                <td>{{ Math.trunc(employer.avg_num_filings).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                <td>{{ employer.year }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation e ample" v-if="employer_count > 10">
                        <ul class="pagination">
                            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchEmployers(pagination.prev_page_url)">Previous</a></li>
                            <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                            <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchEmployers(pagination.next_page_url)">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

    props : ['team', 'team_name'],
    data () {
        return {
            employers: [],
            pagination: {},
            employer_count: 0,
            window: {
                width: 2000,
                height: 2000
            }
        };
    },

    created() {
        this.fetchEmployers();
        window.addEventListener('resize', this.handleResize)
        this.handleResize();
    },

    destroyed() {
        window.removeEventListener('resize', this.handleResize)
    },

    methods: {
        fetchEmployers(page_url) {
            page_url = page_url || '/get_top_companies/';
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.employers = res.data;
                    this.employer_count = res.meta.total;
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
                console.log(pagination);
                this.pagination = pagination;
        },    
    }
};
</script>
