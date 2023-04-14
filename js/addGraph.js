const addChartButton = document.getElementById('addChart');
const menuContainer = document.querySelector('.menu-container');

addChartButton.addEventListener('click', function() {
  if (menuContainer.style.display === 'none') {
    menuContainer.style.display = 'block';
  } else {
    menuContainer.style.display = 'none';
  }
});

const selectDataset = document.getElementById("select-dataset");
const selectGraphtype = document.getElementById("select-graphtype");

const datasetOptions = {
  "percentage-legal-compliance": [
    { value: "pie-chart", label: "Pie Chart" },
    { value: "bar-chart", label: "Bar Chart" },
    { value: "line-chart", label: "Line Chart" }
  ],
  "legal-red-tasks": [
    { value: "bar-chart", label: "Bar Chart" },
    { value: "line-chart", label: "Line Chart" }
  ],
  "legal-amber-tasks": [
    { value: "pie-chart", label: "Pie Chart" },
    { value: "line-chart", label: "Line Chart" }
  ]
};

// Function to update the options in the graphtype select
function updateGraphtypeOptions() {
  // Get the currently selected dataset
  const dataset = selectDataset.value;
  // Get the options for the selected dataset
  const options = datasetOptions[dataset];
  // Remove all existing options
  selectGraphtype.innerHTML = "";
  // Add the new options
  for (const option of options) {
    const { value, label } = option;
    const optionElement = document.createElement("option");
    optionElement.value = value;
    optionElement.textContent = label;
    selectGraphtype.appendChild(optionElement);
  }
}

// Add an event listener to the dataset select
selectDataset.addEventListener("change", updateGraphtypeOptions);

// Call the function to populate the graphtype select with the initial options
updateGraphtypeOptions();

function addDataPoint() {
  const container = document.getElementById("data-point-container");
  const input = document.createElement("input");
  input.type = "text";
  input.name = "data-point[]";
  container.appendChild(input);
}