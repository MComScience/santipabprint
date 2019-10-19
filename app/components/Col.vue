<template>
  <div :class="colClass">
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: "Col",
  props: ["xs", "sm", "md", "lg"],
  computed: {
    colClass: function() {
      let classNames = [];
      if (this.xs) {
        const prefix = this.prefix("xs");
        classNames.push(prefix + this.xs);
      }
      if (this.sm) {
        const prefix = this.prefix("sm");
        classNames.push(prefix + this.sm);
      }
      if (this.md) {
        const prefix = this.prefix("md");
        classNames.push(prefix + this.md);
      }
      if (this.lg) {
        const prefix = this.prefix("lg");
        classNames.push(prefix + this.lg);
      }
      return classNames.join(" ");
    }
  },
  methods: {
    prefix: function(col) {
      let prefix = "";
      switch (col) {
        case "xs":
          prefix = "col-xs-";
          break;
        case "sm":
          prefix = "col-sm-";
          break;
        case "md":
          prefix = "col-md-";
          break;
        case "lg":
          prefix = "col-lg-";
          break;
        default:
          break;
      }
      return prefix;
    }
  }
};
</script>