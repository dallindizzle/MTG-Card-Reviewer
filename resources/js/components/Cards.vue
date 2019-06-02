<template>
    <div>
        <form @submit.prevent="addcard" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Name" v-model="card.name">
            </div>
            <div class="form-group">
                <textarea type="text" class="form-control" placeholder="Opinion" v-model="card.op"></textarea>
            </div>
            <button type="submit" class="btn btn-success btn-block">Save</button>
        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]"><a @click="fetchCards(pagination.prev_page_url)" class="page-link" href="#">Previous</a></li>
                <li class="page-item disabled text-dark"><a class="page-link" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a @click="fetchCards(pagination.next_page_url)" class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
        <div class="">
            <div v-bind:key="card.name" v-for="card in cards" class="card mb-3 w-100">
                <CardItem  v-bind:card="card"/>
                <button @click="editCard(card)" class="btn btn-warning my-2">Edit</button>
                <button @click="deleteCard(card.id)" class="btn btn-danger my-2">Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
import CardItem from './CardItem';

export default {
    name: "Cards",
    components: {
        CardItem
    },
    data() {
        return {
            cards: [],
            card: {
                id: '',
                name: '',
                body: ''
            },
            card_id: '',
            pagination: {},
            edit: false
        }
    },
    methods: {
        addCard(newCard) {
            this.cards.push(newCard);
        },

        fetchCards(page_url) {
            let vm = this;
            page_url = page_url || 'http://lcards.test/api/cards';
            fetch(page_url)
            .then(res => res.json())
            .then(res => {
                this.cards = res.data;
                vm.makePagination(res.meta, res.links);
            })
            .catch(err => console.log(err));
        },

        deleteCard(id) {
            if(confirm('Are you Sure?')) {
                fetch(`api/card/${id}`, {
                method: 'delete'
                })
                .then(res => res.json())
                .then(data => {
                    alert('Card Removed');
                    this.fetchcards();
                })
                .catch(err => console.log(err));
            }
        },
        addcard() {
            if(this.edit === false) {
                // Add
                fetch('api/card', {
                    method: 'post',
                    body: JSON.stringify(this.card),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.card.name = '';
                    this.card.op = '';
                    alert('Card Added');
                    this.fetchCards();
                })
                .catch(err => console.log(err));
            }
            else {
                // Update
                fetch('api/card', {
                    method: 'put',
                    body: JSON.stringify(this.card),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.card.name = '';
                    this.card.op = '';
                    alert('Card Updated');
                    this.fetchCards();
                })
                .catch(err => console.log(err));
            }
        },
        
        editCard(card) {
            this.edit = true;
            this.card.id = card.id;
            this.card.card_id = card.id;
            this.card.name = card.name;
            this.card.op = card.op;
        },

        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            }
            this.pagination = pagination;
        }
    },

    created() {
        this.fetchCards();
    }
}
</script>

