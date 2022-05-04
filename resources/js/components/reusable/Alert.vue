<template>
  <div
    class="alert alert-dismissible fade show"
    :class="`alert-${type}`"
    role="alert"
  >
    <div v-if="typeof messages === 'string'" v-html="messages"></div>
    <div v-else-if="messages.length === 1" v-html="messages[0]"></div>

    <ul v-else class="mb-0">
      <li v-for="(msg, i) in messages" :key="i" v-html="msg"></li>
    </ul>
    <button
      type="button"
      class="btn-close"
      data-bs-dismiss="alert"
      aria-label="Close"
      @click="$emit('close')"
    ></button>
  </div>
</template>

<script>
export default {
  name: "Alert",
  props: {
    messages: {
      type: [String, Array],
      required: true,
    },
    type: String,
    required: false,
    default: () => "warning",
    validator: (value) =>
      [
        "success",
        "primary",
        "danger",
        "warning",
        "secondary",
        "info",
        "light",
        "dark",
      ].indexOf(value) >= 0,
  },
};
</script>

<style>
</style>