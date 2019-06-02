<template>

        <div class="row no-gutters">
            <div class="col-md-3">
                <img v-bind:src="image" class="card-img" alt="">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5>{{card.name}}</h5>
                    <p class="card-text">{{card.op}}</p>
                </div>
            </div>
        </div>

</template>

<script>
import axios from 'axios';

export default {
    name: "CardItem",
    props: ["card"],
    data() {
        return {
            image: ''
        }
    },
    created() {
        setTimeout(() => {
            axios.get(`https://api.scryfall.com/cards/named?fuzzy=${this.$props.card.name}`)
            .then(res => this.image = res.data.image_uris.normal)
            .catch(err => console.log(err));
        }, 100);
    }
}
</script>
