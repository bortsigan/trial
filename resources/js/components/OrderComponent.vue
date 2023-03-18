<template>
    <div>
        <Header />
        <div class="accordion" id="orderAccordion">
            <div class="row card-labels">
                <h4 class="col-3 text-center">
                    Delivery On
                </h4>
                <h4 class="col-3 text-center">
                    Total Price
                </h4>
                <h4 class="col-3 text-center">
                    Details
                </h4>
                <h4 class="col-3 text-center">
                    Invoice
                </h4>
            </div>
            <div v-for="(order, index) in orders" :key="index" class="card">
                <div class="card-header" :id="'heading' + index">
                    <h5 class="mb-0">
                        <div class="row pt-3 pb-3" data-toggle="collapse" :data-target="'#collapse' + index"
                            :aria-expanded="activeIndex === index" :aria-controls="'collapse' + index">
                            <div class="col-3 col-lg-3 text-center" @click="toggleAccordion(index, order.id)">
                                {{ order.delivery_date | dateFormat }}
                            </div>
                            <div class="col-3 col-lg-3 text-center" @click="toggleAccordion(index, order.id)">
                                {{ order.total_price }}
                            </div>
                            <div class="col-3 text-center" @click="toggleAccordion(index, order.id)">
                                <p>{{ (activeIndex === index) ? "Hide Details" : "View Details" }}</p>
                            </div>
                            <div class="col-3 text-center">
                                <a href="#" class="btn btn-primary" @click.prevent="selectedDL(order.id)">
                                    <i class="bi bi-cloud-arrow-down-fill"></i> Button
                                </a>
                            </div>
                        </div>
                    </h5>
                </div>
                <div :id="'collapse' + index" class="collapse" :class="{ 'show': activeIndex === index }"
                    :aria-labelledby="'heading' + index" data-parent="#orderAccordion">
                    <div class="card-body px-5">
                        <div class="row">
                            <h4 class="col-10"> Build your own meal plan - Vegan </h4>
                            <h4 class="col-2">${{ orderPrice }}</h4>
                        </div>
                        <div v-show="orderDetails.meals" class="px-2">
                            <h5 class="content-title">{{ mealTitle }}</h5>
                    
                            <p v-for="(meals, ix) in orderDetails.meals" :key="ix">
                                {{ meals.count }}x {{ meals.meal_name }} 
                                <i class="bi bi-info-circle-fill"></i>
                            </p>
                        </div>

                        <div v-show="orderDetails.snack"  class="px-2">
                            <h5 class="content-title">Snack</h5>
                    
                            <p v-for="(snacks, ix) in orderDetails.snack" :key="ix">
                                {{ snacks.count }}x {{ snacks.meal_name }}
                                <i class="bi bi-info-circle-fill"></i>
                            </p>
                        </div>

                        <div v-show="orderDetails.drink"  class="px-2">
                            <h5 class="content-title">Drink</h5>
                
                            <p v-for="(drinks, ix) in orderDetails.drink" :key="ix">
                                {{ drinks.count }}x {{ drinks.meal_name }}
                                <i class="bi bi-info-circle-fill"></i>
                            </p>
                        </div>

                        <div v-show="orderDetails.side"  class="px-2">
                            <h5 class="content-title">Sides</h5>
            
                            <p v-for="(sides, ix) in orderDetails.side" :key="ix">
                                {{ sides.count }}x {{ sides.meal_name }}
                                <i class="bi bi-info-circle-fill"></i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import 'bootstrap-icons/font/bootstrap-icons.css';
import Header from './Header.vue';

export default {
  components: { Header },
    data () {
        return {
            orders: [],
            orderDetails: [],
            mealGroups: [],
            mealTitle: null,
            orderPrice: null,
            activeIndex: null,
        };
    },
    filters: {
        dateFormat: function(value) {
            return value ? moment(value).format("YYYY-MM-DD") : 'No delivery date';
        }
    },
    methods: {
        async getOrders() {
            this.orders = [];
            await axios.get("api/orders")
                .then(response => {
                    this.orders = response.data.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        async getOrderDetails(id) {
            this.orderDetails = [];
            this.mealGroups = [];
            this.mealTitle = null;

            await axios.get(`api/orders/details/${id}`)
                .then(response => {
                    let {data} = response;

                    this.orderDetails = data.orderDetails;
                    this.mealGroups = data.mealGroups;
                    this.mealTitle = data.mealTitle;
                    this.orderPrice = data.orderPrice;

                })
                .catch(error => {
                    alert(error);
                });
        },
        toggleAccordion (index, orderId) {
            this.activeIndex = this.activeIndex === index ? null : index;
            this.getOrderDetails(orderId);
        },
        selectedDL(id) {
            console.log(id);
            window.location.href= `api/orders/export/${id}`;
        }
    },
    mounted () {
        this.getOrders();
    }
};
</script>

<style scoped>
.accordion {
    margin: auto;
    margin-top: 20px;
    max-width: 1000px;
}

.card-labels {
    margin: auto;
    max-width: 1000px;
    border-bottom: solid 3px;
    margin-bottom: 20px;
}

.card-header {
    max-width: 1000px;
    background-color: #FFFF !important;
    cursor: pointer;
    text-align: center;
    padding: 0 !important;
    border-bottom-style: dotted !important;
    border-bottom: 2px;
}

.card-header button {
    text-align: left;
    width: 100%;
    font-weight: bold;
}

.card-body {
    background-color: #cdf0ec;
    padding: 10px;
}

.card-body .content-title {
    color: #d19018;
    font-weight: 700;
}
</style>
