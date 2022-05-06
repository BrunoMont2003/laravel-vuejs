<template>
  <div>
    <div>
      <Alert
        v-if="
          (Array.isArray(alert.messages) && alert.messages.length > 0) ||
          typeof alert.messages === 'string'
        "
        :messages="alert.messages"
        :type="alert.type"
        @close="alert.messages = []"
      />
    </div>
    <div class="row mb-3">
      <div class="col-sm-8">
        <div class="form-group">
          <input
            type="text"
            v-model="resume.title"
            placeholder="Resume Title"
            required
            autofocus
            class="form-control w-100"
          />
        </div>
      </div>
      <div class="col-sm-4">
        <button class="btn btn-success btn-block" @click="submit()">
          <span>Submit</span>
          <FontAwesomeIcon icon="upload" />
        </button>
      </div>
    </div>
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
          title="Profile"
          self="profiles"
          :model="resume.content.basics"
          :schema="schemas.profiles"
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
        <DynamicForm
          title="Award"
          self="awards"
          :model="resume.content"
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
import jsonresume from "./jsonresume";
import axios from "axios";
import Alert from "../reusable/Alert";
export default {
  name: "ResumeForm",
  components: {
    Tabs,
    Tab,
    VueFormGenerator,
    DynamicForm,
    ListForm,
    Alert,
  },
  props: {
    update: false,
    resume: {
      type: Object,
      id: null,
      title: "Resume Title",
      content: jsonresume,
    },
  },
  data() {
    return {
      // resume: {
      //   title: "",
      //   content: {
      //     basics: {
      //       location: {},
      //       profiles: [],
      //     },
      //     work: [],
      //     education: [],
      //     awards: {},
      //     skills: [],
      //   },
      // },
      alert: {
        type: "warning",
        messages: [],
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
  methods: {
    validate(target, parent = "resume") {
      let errors = [];
      for (const [prop, value] of Object.entries(target)) {
        if (Array.isArray(value)) {
          if (value.length === 0) {
            errors.push(`${parent} > ${prop} must have at least one element`);
            continue;
          }
          for (const i in value) {
            if (typeof value[i] === null || value[i] === "") {
              errors.push(`${parent} > ${prop} > ${i} cannot be empty`);
            } else if (typeof value[i] === "object") {
              errors = errors.concat(
                this.validate(value[i], `${parent} > ${prop} > ${i}`)
              );
            }
          }
        } else if (typeof value === "object") {
          errors = errors.concat(this.validate(value, `${parent} > ${prop}`));
        } else if (value === null || value === "") {
          errors.push(`${parent} > ${prop} is required`);
        }
      }
      return errors;
    },
    isValid() {
      const { alert } = this.$data;
      const { resume } = this.$props;
      alert.messages = [];
      const errors = this.validate(resume.content);
      if (errors.length < 1) {
        return true;
      }
      alert.messages = errors.slice(0, 3);
      if (errors.length > 3) {
        alert.messages.push(
          `<strong>${errors.length - 3} more errors ...</strong>`
        );
      }
      alert.type = "warning";
      return false;
    },
    async submit() {
      const { alert } = this.$data;
      const { resume, update } = this.$props;
      if (!this.isValid()) {
        return;
      }
      try {
        const { data, status } = update
          ? await axios.put("/resumes/" + resume.id, resume)
          : await axios.post("/resumes", resume);
        console.log(data);
        if (status >= 200 && status < 300) {
          window.location = "/resumes";
        }
      } catch (e) {
        alert.messages = [];
        const errors = e.response.data.errors;
        for (const [prop, value] of Object.entries(errors)) {
          const origin = prop.split(".").join(" > ");
          for (const error of value) {
            const message = error.replace(prop, `<strong>${origin}</strong>`);
            alert.messages.push(message);
          }
        }
        alert.type = "danger";
      }
    },
  },
};
</script>
<style>
@import url("https://fonts.googleapis.com/css2?family=Source+Code+Pro&display=swap");
.form-control {
  background-color: transparent !important;
  transition: all 0.3s ease-in-out !important;
  color: #000 !important;
  font-family: "Source Code Pro", monospace !important;
}
input[type="tel"].form-control,
input[type="url"].form-control,
input[type="date"].form-control,
input[type="email"].form-control,
input[type="text"].form-control {
  min-height: 2.5rem !important;
}
.form-control:focus {
  background-color: rgb(255, 255, 255) !important;
  box-shadow: rgba(13, 110, 253, 0.3) 0px 0px 0px 3px;
}
.form-group label {
  font-weight: bold;
  margin-bottom: 0.5em;
}
</style>