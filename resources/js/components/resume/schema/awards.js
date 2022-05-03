export default {
  fields: [
    // Title
    {
      type: "input",
      inputType: "text",
      label: "Title",
      placeholder: "Award Title",
      model: "title",
      styleClasses: ["col-12", "col-md-4", "px-1"],
    },
    // Date
    {
      type: "input",
      inputType: "date",
      label: "Date",
      model: "date",
      styleClasses: ["col-12", "col-md-4", "px-1"],
    },
    // Awarder
    {
      type: "input",
      inputType: "text",
      label: "Awarder",
      placeholder: "Company",
      model: "awarder",
      styleClasses: ["col-12", "col-md-4", "px-1"],
    },
    // Summary
    {
      type: "textArea",
      inputType: "text",
      label: "Summary",
      placeholder: "There is no spoon.",
      model: "summary",
      styleClasses: ["col-12", "px-1"],
    },
  ],
};
