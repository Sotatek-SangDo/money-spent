<template>
    <div class="top-right">
        <div class="material-icons mdl-badge mdl-badge--overlap" id="message" :data-badge="sortedSpend.length">announcement</div>
        <div for="message" class="mdl-js-menu mdl-js-ripple-effect mdl-menu">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Username</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                <tr :class="'success'" v-for="(spend, key) in sortedSpend" @click="updateMessage(spend)">
                    <td>{{ spend.title }}</td>
                    <td>{{ spend.name }}</td>
                    <td>{{ spend.amount }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['current'],
        data() {
            return {
                spends: [],
                user: [],
                children: []
            }
        },
        created() {
            this.$http.get('/get-children').then((response) => {
                this.children = response.data;
            })
            this.fetchLeaderboard();
            this.listenForChanges();
        },
        methods: {
            fetchLeaderboard() {
                this.$http.get('/messagelive').then((response) => {
                    this.user = response.data.user;
                    this.spends = response.data.spend;
                })
            },
            listenForChanges() {
                let self = this;
                Echo.channel('messagelive')
                .listen('UserCreateSpend', (e) => {
                    var spend = self.spends.find((s) => s.id === e.id),
                        child = self.children.find((c) => c.id == e.user_id)
                        if(!spend && child){
                            self.spends.push(e)
                        }
                    })
            },
            updateMessage(spend) {
                let url = `/spend/update/${spend.id}`;
                this.$http.get(url).then((response) => {
                    this.fetchLeaderboard();
                })
            }
        },
        computed: {
            sortedSpend() {
                return this.spends;
            }
        }
    }
</script>
