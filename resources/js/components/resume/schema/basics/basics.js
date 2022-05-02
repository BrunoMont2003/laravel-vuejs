export default {
  fields: [
    // Picture
    {
      type: "resume-image",
      label: "Resume Profile Image",
      model: "picture",
    },

    // Name
    {
      type: "input",
      inputType: "text",
      placeholder: "Your name",
      label: "Name",
      model: "name",
      styleClasses: ["col-12", "col-md-6", "px-1"],
    },
    // Label
    {
      type: "input",
      inputType: "text",
      placeholder: "Programmer",
      label: "Label",
      model: "label",
      styleClasses: ["col-12", "col-md-6", "px-1"],
    },
    // Email
    {
      type: "input",
      inputType: "email",
      placeholder: "john@gmail.com",
      label: "Email",
      model: "email",
      validator: "email",
      styleClasses: ["col-12", "col-md-4", "px-1"],
    },
    // Phone
    {
      type: "input",
      inputType: "tel",
      placeholder: "987654321",
      label: "Phone",
      model: "Phone",
      styleClasses: ["col-12", "col-md-4", "px-1"],
    },
    // website
    {
      type: "input",
      inputType: "text",
      placeholder: "https://johndoe.com",
      label: "Website",
      model: "website",
      validator: "url",
      styleClasses: ["col-12", "col-md-4", "px-1"],
    },
    // Summary
    {
      type: "textArea",
      inputType: "text",
      placeholder: "A little bit about yourself",
      label: "Summary",
      model: "summary",
      styleClasses: ["px-1"],
    },
  ],
};
