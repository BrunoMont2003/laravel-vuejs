<template>
  <BTab title-item-class="p-2">
    <template #title>
      <div class="d-flex justify-content-center align-items-center p-2">
        <font-awesome-icon
          :icon="icon"
          style="font-size: 20px; margin-right: 1rem"
        ></font-awesome-icon>
        <span class="d-none d-md-block">
          {{ title }}
        </span>
      </div>
    </template>
    <slot></slot>
  </BTab>
</template>

<script>
import { BTab } from "bootstrap-vue";
export default {
  name: "Tab",
  props: {
    title: {
      type: String,
      required: true,
    },
    icon: {
      type: String,
    },
  },
  components: {
    BTab,
  },
};
</script>
