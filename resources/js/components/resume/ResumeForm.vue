<template>
  <div>
    <Tabs>
      <Tab title="Basics" icon="user">
        <div class="pb-5 pt-3">
          <VueFormGenerator
            :schema="schemas.basics"
            :model="resume.content.basics"
            :options="options"
          />
          <VueFormGenerator
            :schema="schemas.location"
            :model="resume.content.basics.location"
            :options="options"
          />
        </div>
      </Tab>
      <Tab title="Profiles" icon="hashtag">
        <DynamicForm
          title="Profiles"
          :model="resume.content.basics"
          :schema="schemas.profiles"
          self="profile"
        />
      </Tab>
      <Tab title="Work" icon="briefcase">
        <DynamicForm
          title="Work"
          self="work"
          :model="resume.content"
          :schema="schemas.work"
          :subforms="subforms.highlights"
        />
      </Tab>
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
import location from "./schema/basics/location";
import DynamicForm from "./dynamic/DynamicForm";
import profiles from "./schema/basics/profiles";
import work from "./schema/work";
import ListForm from "./dynamic/ListForm";
export default {
  name: "ResumeForm",
  components: {
    Tabs,
    Tab,
    VueFormGenerator,
    DynamicForm,
    ListForm,
  },
  data() {
    return {
      resume: {
        title: "",
        content: {
          basics: {
            location: {},
            profiles: [],
          },
          work: [],
        },
      },
      schemas: {
        basics,
        location,
        profiles,
        work,
      },
      subforms: {
        highlights: [
          {
            component: ListForm,
            props: {
              self: "highlights",
              title: "Highlights",
              placeholder: "Started company",
            },
          },
        ],
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
.form-control {
  background-color: transparent !important;
  transition: all 0.3s ease-in-out !important;
}
.form-control:focus {
  background-color: rgb(255, 255, 255) !important;
  box-shadow: rgba(13, 110, 253, 0.3) 0px 0px 0px 3px;
}
</style>