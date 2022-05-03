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
      <Tab title="Education" icon="building">
        <DynamicForm
          title="Education"
          self="education"
          :model="resume.content"
          :schema="schemas.education"
          :subforms="subforms.courses"
        />
      </Tab>
      <Tab title="Awards" icon="award">
        <VueFormGenerator
          title="Awards"
          :model="resume.awards"
          :schema="schemas.awards"
        />
      </Tab>
      <Tab title="Skills" icon="bolt">
        <DynamicForm
          title="Skill"
          self="skills"
          :model="resume.content"
          :schema="schemas.skills"
          :subforms="subforms.keywords"
        />
      </Tab>
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
import education from "./schema/education";
import awards from "./schema/awards";
import skills from "./schema/skills";
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
          education: [],
          awards: {},
          skills: [],
        },
      },
      schemas: {
        basics,
        location,
        profiles,
        work,
        education,
        awards,
        skills,
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
        courses: [
          {
            component: ListForm,
            props: {
              self: "courses",
              title: "Courses",
              placeholder: "Frontend",
            },
          },
        ],
        keywords: [
          {
            component: ListForm,
            props: {
              self: "keywords",
              title: "Keywords",
              placeholder: "React Js",
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