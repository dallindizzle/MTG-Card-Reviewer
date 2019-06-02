<template>
    <div class="form-group">
        <form @submit="addCard">
            <input class="form-control" type="text" name="name" v-model="name" placeholder="Add Card">
            <input class="form-control" type="text" name="op" v-model="op" placeholder="Add opinion">
            <input type="submit" value="Submit" class="btn btn-primary my-2">
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            op: ''
        }
    },
    methods: {
        addCard(e) {
            e.preventDefault();
            const newCard = {
                name: this.name,
                op: this.op
            }

            // Send up to parent
            this.$emit('add-card', newCard);

            this.name = '';
            this.op = '';
        }
    },
    name: 'AddCards'
}
</script>
