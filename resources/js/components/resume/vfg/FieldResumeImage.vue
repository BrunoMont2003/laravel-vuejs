<template>
  <div class="gap-3 w-100 d-flex flex-column flex-md-row py-2">
    <div>
      <img class="img-fluid profile-picture" :src="image" alt="profile-image" />
    </div>
    <div class="align-self-center">
      <input class="form-control" type="file" @change="onImageChange($event)" />
    </div>
  </div>
</template>

<script>
import { abstractField } from "vue-form-generator";
export default {
  name: "FieldResumeImage",
  mixins: [abstractField],
  data() {
    return {
      image: this.model[this.schema.model],
      // image:
      //   "https://i.pinimg.com/originals/74/e9/cb/74e9cbb3ea62e9b44e39ace1cc4fdad7.png",
      reader: new FileReader(),
    };
  },
  created() {
    this.reader.onload = (e) => {
      const blob = e.target.result;
      this.image = blob;
      this.model[this.schema.model] = blob;
    };
  },
  methods: {
    onImageChange(e) {
      this.reader.readAsDataURL(e.target.files[0]);
    },
  },
};
</script>
<style>
.profile-picture {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  object-fit: cover;
}
</style>