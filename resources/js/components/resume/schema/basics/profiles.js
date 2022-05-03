export default {
  fields: [
    {
      type: "input",
      inputType: "text",
      placeholder: "Twitter",
      label: "Network",
      model: "network",
      styleClasses: ["col-12", "col-md-4", "px-1"],
    },
    {
      type: "input",
      inputType: "url",
      placeholder: "https://twitter.com/jhondoe",
      label: "Url",
      model: "url",
      styleClasses: ["col-12", "col-md-4", "px-1"],
    },
    {
      type: "input",
      inputType: "text",
      placeholder: "yourname",
      label: "Username",
      model: "username",
      styleClasses: ["col-12", "col-md-4", "px-1"],
    },
  ],
};
