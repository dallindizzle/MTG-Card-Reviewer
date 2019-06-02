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
    </div>
</template>

<script>
export default {
    name: 'AddCardForm',
    data() {
        return {
            card: {
                id: '',
                name: '',
                body: ''
            },
            card_id: '',
            edit: false
        }
    },
    methods: {
        addcard() {
            if(this.edit === false) {
                // Add
                fetch('http://lcards.test/api/card', {
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

                    this.$emit('added-card');

                    //this.fetchCards();
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
    }
}
</script>

