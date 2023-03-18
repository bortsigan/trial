<template>
  <div class="accordion" id="orderAccordion">
    <div class="row card-labels">
      <h4 class="col-3 text-center border">
        ORDER
      </h4>
      <h4 class="col-3 text-center border">
        Delivery Date
      </h4>
      <h4 class="col-3 text-center border">
        Total Price
      </h4>
      <h4 class="col-2 text-center border">
        Details
      </h4>
      <h4 class="col-1 text-center border">

      </h4>
    </div>
    <div v-for="(order, index) in orders" :key="index" class="card">
      <div class="card-header" :id="'heading' + index" @click="toggleAccordion(index)">
        <h5 class="mb-0">
          <button class="btn btn-link" type="button" data-toggle="collapse" :data-target="'#collapse' + index"
            :aria-expanded="activeIndex === index" :aria-controls="'collapse' + index">
            <div class="row">
              <div class="col-3 col-lg-3 text-center border">
                {{ order.id }}
              </div>
              <div class="col-3 col-lg-3 text-center border">
                {{ order.deliveryDate }}
              </div>
              <div class="col-3 col-lg-3 text-center border">
                {{ order.totalPrice }}
              </div>
              <div class="col-2 text-center border">
                <p>{{ (activeIndex === index) ? "Hide Details" : "Show Details" }}</p>
              </div>
              <div class="col-1 text-center border">
                DL
              </div>
            </div>
          </button>
        </h5>
      </div>
      <div :id="'collapse' + index" class="collapse" :class="{ 'show': activeIndex === index }"
        :aria-labelledby="'heading' + index" data-parent="#orderAccordion">
        <div class="card-body">
          <h6>Details:</h6>
          <p>{{ order.details }}</p>
          <h6>Invoice:</h6>
          <p>{{ order.invoice }}</p>
          <h6>Order Items:</h6>
          <ul>
            <li v-for="(item, i) in order.items" :key="i">{{ item.name }} - Quantity: {{ item.quantity }} -
              Price: ${{ item.price }}</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      orders: [
        {
          id: 1,
          deliveryDate: "2023-03-04",
          totalPrice: 24.99,
          details: "Product 1, Quantity: 2",
          invoice: "ABC123",
          items: [
            { name: "Product 1", quantity: 2, price: 12.99 },
          ]
        },
        {
          id: 2,
          deliveryDate: "2023-03-05",
          totalPrice: 49.99,
          details: "Product 2, Quantity: 1",
          invoice: "DEF456",
          items: [
            { name: "Product 2", quantity: 1, price: 49.99 },
          ]
        },
        {
          id: 3,
          deliveryDate: "2023-03-06",
          totalPrice: 15.00,
          details: "Product 3, Quantity: 3",
          invoice: "GHI789",
          items: [
            { name: "Product 3", quantity: 3, price: 5.00 },
          ]
        },
      ],
      activeIndex: null,
    };
  },
  methods: {
    toggleAccordion (index) {
      this.activeIndex = this.activeIndex === index ? null : index;
    },
  },
};
</script>

<style>
.accordion {
  margin: auto;
  margin-top: 20px;
  max-width: 1000px;
}

.card-labels {
  margin: auto;
  max-width: 1000px;
}

.card-header {
  max-width: 1000px;
  background-color: #f0f0f0;
  cursor: pointer;
  text-align: center;
  padding: 0 !important;
}

.card-header button {
  text-align: left;
  width: 100%;
  font-weight: bold;
}

.card-body {
  background-color: #f8f8f8;
  padding: 10px;
}
</style>
