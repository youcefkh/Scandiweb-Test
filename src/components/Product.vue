<template>
  <div class="product" @click="selectProduct">
    <p>{{ product.sku }}</p>
    <p>{{ product.name }}</p>
    <p>{{ product.price }}$</p>
    <p>
      {{ product.attribute }}: {{ product.value }}
      <span v-if="product.attribute == 'Size'">MB</span>
      <span v-else-if="product.attribute == 'Weight'">KG</span>
    </p>

    <input type="checkbox" class="delete-checkbox" @change="checkbox" />
  </div>
</template>

<script>
export default {
  name: "ProductCard",
  props: ["product"],
  methods: {
    checkbox(e) {
      e.stopPropagation();

      if (e.currentTarget.checked) {
        this.$emit("checked", this.product.id);
        e.currentTarget.parentElement.classList.add("selected");
      } else {
        this.$emit("unchecked", this.product.id);
        e.currentTarget.parentElement.classList.remove("selected");
      }
    },
    selectProduct(e) {
      if (e.target.className !== "delete-checkbox") {
        const checkbox = e.currentTarget.querySelector(".delete-checkbox");
        if (checkbox.checked) {
          checkbox.checked = false;
          this.$emit("unchecked", this.product.id);
          e.currentTarget.classList.remove("selected");
        } else {
          checkbox.checked = true;
          this.$emit("checked", this.product.id);
          e.currentTarget.classList.add("selected");
        }
      }
    },
  },
};
</script>

<style scoped>
.product {
  position: relative;
  display: flex;
  margin: 5px;
  border: 2px solid;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  border-radius: 5%;
  height: 200px;
  cursor: pointer;
}

.product p{
  font-size: 1.2rem;
  margin-bottom: 5px;
}

.product.selected {
  border-color: #0075ff;
}

input.delete-checkbox {
  position: absolute;
  top: 10px;
  left: 10px;
  height: 15px;
  width: 15px;
  cursor: pointer;
}
</style>
