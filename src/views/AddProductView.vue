<template>
  <div class="add_product">
    <div class="header">
      <h1>Add Product</h1>
      <div class="actions">
        <button
          class="btn btn-primary save"
          @click="addProduct"
          :disabled="loading"
        >
          Save
        </button>
        <router-link :to="{ name: 'home' }"
          ><button class="btn btn-danger">Cancel</button>
        </router-link>
      </div>
    </div>

    <form id="product_form">
      <div class="notification" v-if="notification">
        {{ notification }}
      </div>
      <div class="form-group">
        <label for="sku">SKU</label>
        <input
          type="text"
          id="sku"
          placeholder="Enter the SKU"
          v-model="form.sku"
        />
      </div>
      <div class="form-group">
        <label for="name">Name</label>
        <input
          type="text"
          id="name"
          placeholder="Enter the name"
          v-model="form.name"
        />
      </div>
      <div class="form-group">
        <label for="price">Price</label>
        <input
          type="number"
          id="price"
          placeholder="Enter the price"
          v-model="form.price"
        />
      </div>
      <div class="form-group">
        <label for="productType">Type Switcher</label>
        <select id="productType" v-model="form.type">
          <option value="DVD" id="DVD">DVD</option>
          <option value="Book" id="Book">Book</option>
          <option value="Furniture" id="Furniture">Furniture</option>
        </select>
      </div>

      <div class="custom-attributes" id="DVD" v-if="form.type == 'DVD'">
        <div class="form-group">
          <label for="size">Size (MB)</label>
          <input
            type="number"
            id="size"
            placeholder="Enter the size"
            v-model="form.size"
          />
        </div>

        <p class="description">**Please, provide size**</p>
      </div>

      <div class="custom-attributes" id="Book" v-else-if="form.type == 'Book'">
        <div class="form-group">
          <label for="weight">Weight (KG)</label>
          <input
            type="number"
            id="weight"
            placeholder="Enter the weight"
            v-model="form.weight"
          />
        </div>

        <p class="description">**Please, provide weight**</p>
      </div>

      <div
        class="custom-attributes"
        id="Furniture"
        v-else-if="form.type == 'Furniture'"
      >
        <div class="form-group">
          <label for="height">Height (CM)</label>
          <input
            type="number"
            id="height"
            placeholder="Enter the height"
            v-model="form.height"
          />
        </div>

        <div class="form-group">
          <label for="width">Width (CM)</label>
          <input
            type="number"
            id="width"
            placeholder="Enter the width"
            v-model="form.width"
          />
        </div>

        <div class="form-group">
          <label for="length">Length (CM)</label>
          <input
            type="number"
            id="length"
            placeholder="Enter the length"
            v-model="form.length"
          />
        </div>

        <p class="description">**Please, provide dimensions**</p>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "App",
  data() {
    return {
      form: {
        sku: null,
        name: null,
        price: null,
        type: "DVD",
        size: null,
        weight: null,
        height: null,
        width: null,
        length: null,
      },

      notification: null,

      loading: false,
    };
  },

  methods: {
    async addProduct() {
      this.loading = true;
      this.notification = null;
      try {
        const response = await this.axios.post(`${this.$hostname}/product`, {
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json;charset=UTF-8",
          },
          data: {
            ...this.form,
          },
        });
        if (response.status === 201) {
          this.$router.push({ name: "home" });
        } else if (response.data.error) {
          this.notification = response.data.error;
        }
      } catch (error) {
        console.log(error);
      }
      this.loading = false;
    },
  },
};
</script>

<style scoped>
.header .save {
  margin-right: 20px;
}

form#product_form {
  /*min-width: fit-content;*/
  width: 50%;
  margin: auto;
  padding: 40px;
  border-radius: 10px;
  box-shadow: 0px 5px 18px 2px #e9d5d5eb;
}

.form-group {
  margin-bottom: 30px;
  display: flex;
  align-items: center;
}

.form-group label {
  width: 40%;
  font-size: 1.3rem;
  font-family: "Franklin Gothic Medium", "Arial Narrow", Arial, sans-serif;
}

.form-group input,
.form-group select {
  width: 60%;
  height: 40px;
  padding: 5px 10px;
  border-radius: 5px;
  border: 1px solid #685252;
}

.custom-attributes {
  padding: 15px 5px;
  border-top: 1px solid;
  border-bottom: 1px solid;
  border-radius: 10px;
}

.notification {
  display: flex;
  width: 100%;
  height: 40px;
  margin-bottom: 20px;
  padding: 5px 10px;
  background: #ffffcc;
  align-items: center;
  border-radius: 10px;
  font-family: sans-serif;
}

p.description {
  color: #673939;
}

@media (max-width: 640px) {
  form#product_form {
    width: 100%;
  }
  .form-group {
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
  }
  .form-group input,
  .form-group select,
  .form-group label {
    width: 100%;
  }

  .form-group label{
    margin-bottom: 10px;
  }
}

@media (min-width: 641px) and (max-width: 1020px) {
  form#product_form {
    width: 80%;
  }
}
</style>
