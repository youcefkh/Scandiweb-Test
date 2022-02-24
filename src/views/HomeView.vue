<template>
  <div class="product-list">
    <div class="header">
      <h1>Product List</h1>
      <div class="actions">
        <router-link :to="{ name: 'addProduct' }">
          <button id="add-product-btn" class="btn btn-primary">
            ADD
          </button></router-link
        >
        <button
          id="delete-product-btn"
          class="btn btn-danger"
          @click="deleteProduct"
        >
          MASS DELETE
        </button>
      </div>
    </div>
    <div class="products-container">
      <div v-for="p in products" :key="p.id" class="product-wrapper">
        <product :product="p" @checked="addId" @unchecked="removeId" />
      </div>
    </div>
  </div>
</template>

<script>
import Product from "@/components/Product.vue";
export default {
  components: { Product },
  name: "App",
  data() {
    return {
      products: null,
      ids: [],
    };
  },
  methods: {
    addId(id) {
      this.ids.push(id);
    },
    removeId(id) {
      this.ids = this.ids.filter((value) => value !== id);
    },
    async getProducts() {
      try {
        const response = await this.axios.get(`${this.$hostname}/product`);
        this.products = response.data;
      } catch (error) {
        console.log(error);
      }
    },
    async deleteProduct() {
      try {
        await this.axios.delete(`${this.$hostname}/product`, {
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json;charset=UTF-8",
          },
          data: {
            ids: this.ids,
          },
        });
        this.products = this.products.filter(p => !this.ids.includes(p.id))
      } catch (error) {
        console.log(error);
      }
    },
  },

  mounted() {
    this.getProducts();
  },
};
</script>

<style scoped>
.header #add-product-btn {
  margin-right: 20px;
}

.products-container {
  display: flex;
  align-content: center;
  justify-content: flex-start;
  flex-wrap: wrap;
  /* gap: 10px; */
}

.product-wrapper {
  padding: 5px;
  width: 25%;
}

@media (max-width: 640px) {
  .product-wrapper {
    width: 100%;
  }
}

@media (min-width: 641px) and (max-width: 1007px) {
  .product-wrapper {
    width: 50%;
  }
}
</style>
