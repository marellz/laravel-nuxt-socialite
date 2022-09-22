<template>
  <div class="mb-4">
    <label :for="id" class="block text-gray-600 text-sm mb-1">{{
      label
    }}</label>
    <input
      :type="type"
      class="border p-2 rounded block w-full"
      :id="id"
      v-model="val"
      :required="required"
      :disabled="disabled"
    />
  </div>
</template>
<script>
export default {
  name: "FormInput",
  props: {
    value: {
      default: "",
    },
    label: {
      type: String,
      default: null,
    },
    type: {
      type: String,
      default: "text",
    },
    required: {
      type: Boolean,
      default: false,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
  mounted() {
    this.id = Math.random().toString(36).substring(7);
  },
  data() {
    return {
      val: this.value,
      id: null,
    };
  },
  watch: {
    value(v) {
      this.val = v;
    },
    val(v) {
      this.$emit(v);
    },
  },
};
</script>
