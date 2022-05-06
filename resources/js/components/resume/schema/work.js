export default {
  fields: [
    // company
    {
      type: "input",
      inputType: "text",
      placeholder: "Company Name",
      label: "Company",
      model: "company",
      styleClasses: ["col-12", "col-md-4", "px-1"],
    },
    // position
    {
      type: "input",
      inputType: "text",
      placeholder: "President",
      label: "Position",
      model: "position",
      styleClasses: ["col-12", "col-md-4", "px-1"],
    },
    // website
    {
      type: "input",
      inputType: "url",
      placeholder: "http://www.website.com",
      label: "Website",
      model: "website",
      styleClasses: ["col-12", "col-md-4", "px-1"],
      validator: "url",
    },
    // startDate
    {
      type: "input",
      inputType: "date",
      format: "YYYY-MM-DD HH:mm:ss",
      placeholder: "2013-01-01",
      label: "Start Date",
      model: "startDate",
      styleClasses: ["col-12", "col-md-6", "px-1"],
    },
    // endDate
    {
      type: "input",
      inputType: "date",
      format: "YYYY-MM-DD HH:mm:ss",
      placeholder: "2015-01-01",
      label: "End Date",
      model: "endDate",
      styleClasses: ["col-12", "col-md-6", "px-1"],
    },
    // summary
    {
      type: "textArea",
      inputType: "text",
      placeholder: "Description ...",
      label: "Summary",
      model: "summary",
      styleClasses: ["col-12", "px-1"],
    },
  ],
};
