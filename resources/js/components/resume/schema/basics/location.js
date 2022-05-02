export default {
  fields: [
    // Address
    {
      type: "input",
      inputType: "text",
      placeholder: "2578 Broadway St",
      label: "Address",
      model: "address",
      styleClasses: ["col-12", "col-md-6", "px-1"],
    },
    // postalCode
    {
      type: "input",
      inputType: "text",
      placeholder: "CA 97585",
      label: "Postal Code",
      model: "postalCode",
      styleClasses: ["col-12", "col-md-6", "px-1"],
    },
    // city
    {
      type: "input",
      inputType: "text",
      placeholder: "San Francisco",
      label: "City",
      model: "city",
      styleClasses: ["col-12", "col-md-4", "px-1"],
    },
    // countryCode
    {
      type: "input",
      inputType: "text",
      placeholder: "US",
      label: "Country Code",
      model: "countryCode",
      styleClasses: ["col-12", "col-md-4", "px-1"],
    },
    // region
    {
      type: "input",
      inputType: "text",
      placeholder: "California",
      label: "Region",
      model: "region",
      styleClasses: ["col-12", "col-md-4", "px-1"],
    },
  ],
};
