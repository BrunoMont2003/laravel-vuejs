<template>
  <div>
    <Tabs>
      <Tab title="Basics" icon="user">
        <VueFormGenerator
          :schema="schemas.basics"
          :model="resume.content.basics"
          :options="options"
        />
      </Tab>
      <Tab title="Work" icon="briefcase"></Tab>
      <Tab title="Education" icon="building"></Tab>
      <Tab title="Awards" icon="award"></Tab>
      <Tab title="Skills" icon="bolt"></Tab>
    </Tabs>
  </div>
</template>

<script>
import Tabs from "./tabs/Tabs";
import Tab from "./tabs/Tab";
import { component as VueFormGenerator } from "vue-form-generator";
import "vue-form-generator/dist/vfg.css";
import basics from "./schema/basics/basics";
export default {
  name: "ResumeForm",
  components: {
    Tabs,
    Tab,
    VueFormGenerator,
  },
  data() {
    return {
      resume: {
        title: "",
        content: {
          basics: {},
        },
      },
      schemas: {
        basics: basics,
      },
      options: {
        validateAfterLoad: true,
        validateAfterChanged: true,
        validateAsync: true,
      },
    };
  },
};
</script>
<style>
.vue-form-generator {
  margin-top: 1rem;
}
.form-control {
  background-color: transparent !important;
  transition: all 0.3s ease-in-out !important;
}
.form-control:focus {
  background-color: rgb(255, 255, 255) !important;
  box-shadow: rgba(13, 110, 253, 0.3) 0px 0px 0px 3px;
}
</style>