// Variables to track visibility state
let isPolygonVisible = false;
let isMarkerVisible = false;
let plotData = [];
let plotDataFilter = [];

let MarkerInfoData = [];
let MarkerInfoDataFilter = [];

let PolygonInfoData = [];
let PolygonInfoDataFilter = [];

let serviceTypes = [];
let services = [];
let plotTypes = [];
let plots = [];
let fees = [];

fetchPlots();

// DOM Elements
const serviceTypeSelect = document.getElementById("serviceType");
const servicesSelect = document.getElementById("services");
const plotTypesSelect = document.getElementById("plotTypes");
const servicesDiv = document.getElementById("servicesDiv");
const plotTypesDiv = document.getElementById("plotTypesDiv");
const selectionCon = document.getElementById("selectionCon");
const plotGrid = document.getElementById("plotGrid");
const finalPlotDiv = document.getElementById("finalPlotDiv");
const finalPlotSelect = document.getElementById("plot_code");
const feesDisplay = document.getElementById("feesDisplay");
const feesDetails = document.getElementById("feesDetails");
const feesInput = document.getElementById("amount");
const feesCode = document.getElementById("fee_code");

const plot_name = document.getElementById("plot_name");

//------------------------ Initialize the map------------------------//

const map = L.map("map").setView([14.5775332, 121.0262312], 17); // Default center: London

// Add OpenStreetMap tile layer
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  maxZoom: 19,
  minZoom: 17,
  attribution: "© OpenStreetMap contributors",
}).addTo(map);

// Layer groups to manage markers and polygons
const markerLayer = L.layerGroup().addTo(map); // Layer group for markers
const polygonLayer = L.layerGroup().addTo(map); // Layer group for polygons

// Fetch and process plot data from the PHP API
//------------------------ Function to get unique plot_type_name groups------------------------//
function getUniquePlotTypeGroups(PolygonInfo) {
  const plotGroups = {};

  PolygonInfo.forEach((plot) => {
    // If the plot_type_name doesn't exist, create a new group
    if (!plotGroups[plot.plot_type_name]) {
      plotGroups[plot.plot_type_name] = [];
    }
    plotGroups[plot.plot_type_name].push(plot);
  });

  return plotGroups;
}
//------------------------ Function to check availability for each plot_type_name group------------------------//
function checkAvailabilityForPlotGroups(plotGroups) {
  // Iterate through each plot_type_name
  for (const plotTypeName in plotGroups) {
    const plots = plotGroups[plotTypeName];
    const isAvailable = plots.some((plot) => plot.availability === "1");

    // Add availability status to the group
    plotGroups[plotTypeName].isAvailable = isAvailable ? "green" : "red";
  }

  return plotGroups;
}
// ------------------------Function to add polygons to the map------------------------//
function addPolygonsToMap(plotGroups) {
  Object.keys(plotGroups).forEach((plotTypeName) => {
    const plots = plotGroups[plotTypeName];

    // Get unique coordinates for each plot_type_name
    const uniqueGeoPos = plots.reduce((acc, plot) => {
      const geoPos = JSON.parse(plot.geo_position); // Parse geo_position
      geoPos.forEach((coord) => {
        if (
          !acc.some(
            (existingCoord) =>
              existingCoord[0] === coord[0] && existingCoord[1] === coord[1]
          )
        ) {
          acc.push(coord);
        }
      });
      return acc;
    }, []); // Unique coordinates

    // Determine polygon color based on availability
    const polygonColor = plots.isAvailable === "green" ? "green" : "red";

    // Slice the plot name to remove everything after the first "-"
    const plotName = plots[0].plot_code.split("-")[0]; // Get the part before the "-" symbol (using the first plot's code)

    // Create the polygon with a popup
    const polygon = L.polygon(uniqueGeoPos, {
      color: polygonColor,
    }).bindPopup(`
        <strong>Plot Type:</strong> ${plotTypeName}<br>
       
        <strong>Service:</strong> ${plots[0].service_type_name}<br>
        <strong>Availability:</strong> ${
          plots.isAvailable === "green" ? "Available" : "Not Available"
        }
      `);

    polygonLayer.addLayer(polygon); // Add the polygon to the polygon layer group
  });
}
//------------------------ Get Plot Data ------------------------ //
async function fetchPlots() {
  try {
    const response = await fetch("api/plots.php");
    const data = await response.json();

    // Initialize arrays to hold MarkerInfo and PolygonInfo
    const MarkerInfo = [];
    const PolygonInfo = [];

    // Iterate through the data and categorize based on `plot_type_name`
    data.forEach((plot) => {
      // Separate Marker and Polygon data based on plot_type_name
      if (plot.plot_type_name === "Exclusive Lot/Niches") {
        MarkerInfo.push(plot);
      } else {
        PolygonInfo.push(plot);
      }
    });
    PolygonInfoData = PolygonInfo;
    MarkerInfoData = MarkerInfo;
    plotData = data;
    ProcessPlots(MarkerInfo, PolygonInfo);
  } catch (error) {}
}
// ------------------------ Filter Plot Data ------------------------ //
async function filteredPlot() {
  try {
    // const response = await fetch("get_plots.php");
    // const data = await response.json();

    // Initialize arrays to hold MarkerInfo and PolygonInfo
    const MarkerInfo = [];
    const PolygonInfo = [];

    // Iterate through the data and categorize based on `plot_type_name`
    plotDataFilter.forEach((plot) => {
      // Separate Marker and Polygon data based on plot_type_name
      if (plot.plot_type_name === "Exclusive Lot/Niches") {
        MarkerInfo.push(plot);
      } else {
        PolygonInfo.push(plot);
      }
    });
    PolygonInfoData = PolygonInfo;
    MarkerInfoData = MarkerInfo;
    // plotData = data;
    ProcessPlots(MarkerInfo, PolygonInfo);
  } catch (error) {}
}

// ------------------------ Add the Markers and Polygon to the Map ------------------------//
async function ProcessPlots(MarkerInfo, PolygonInfo) {
  try {
    // Fetch data from the PHP endpoint
    markerLayer.clearLayers(); // Clear all markers from the marker layer group
    polygonLayer.clearLayers(); // Clear all polygons from the polygon layer group

    // Add Markers to map
    MarkerInfo.forEach((plot) => {
      const geoPos = JSON.parse(plot.geo_position); // Parse geo_position from string to array
      const markerColor = plot.availability === "1" ? "green" : "red"; // Determine color based on availability

      // Slice name to remove everything after the first "-"
      const plotName = plot.plot_code; // Get the part before the "-" symbol
      //console.log(geoPos);
      const marker = L.circleMarker(geoPos, {
        color: markerColor,
        radius: 8,
      }).bindPopup(`
        <strong>Plot Code:</strong> ${plotName}<br> <!-- Display sliced plot name -->
        <strong>Tier:</strong> ${plot.tier}<br>
        <strong>Service:</strong> ${plot.service_type_name}<br>
        <strong>Availability:</strong> ${
          plot.availability === "1" ? "Available" : "Not Available"
        }
      `);

      markerLayer.addLayer(marker); // Add the marker to the marker layer group
    });

    // Add Polygons to map
    // Add Polygons to map
    const plotGroups = getUniquePlotTypeGroups(PolygonInfo);

    // Step 2: Check availability for each plot type group
    const plotGroupsWithAvailability =
      checkAvailabilityForPlotGroups(plotGroups);

    // Step 3: Add polygons to the map
    addPolygonsToMap(plotGroupsWithAvailability);
  } catch (error) {
    //console.error("Error fetching plots data:", error);
  }
}

//------------------------ Fetch Data from APIs ------------------------//
async function fetchData() {
  try {
    const [
      serviceTypesResponse,
      servicesResponse,
      plotTypesResponse,
      plotsResponse,
      feesResponse,
    ] = await Promise.all([
      fetch("api/services_types.php").then((res) => res.json()),
      fetch("api/services.php").then((res) => res.json()),
      fetch("api/plot_types.php").then((res) => res.json()),
      fetch("api/plots.php").then((res) => res.json()),
      fetch("api/fees.php").then((res) => res.json()),
    ]);

    serviceTypes = serviceTypesResponse;
    services = servicesResponse;
    plotTypes = plotTypesResponse;
    plots = plotsResponse;
    fees = feesResponse;

    //console.log(serviceTypes, services, plotTypes, plots);
    // Populate Service Types
    serviceTypes.forEach((st) => {
      const option = document.createElement("option");
      option.value = st.service_type_name;
      option.textContent = st.service_type_name;
      serviceTypeSelect.appendChild(option);
    });
  } catch (error) {
    //console.error("Error fetching data:", error);
  }
}

// Call fetchData on page load
window.onload = fetchData;
fetchData();
//------------------------ Event Listeners ------------------------//

// Runs if the a service type was selected to show the Services selection
serviceTypeSelect.addEventListener("change", () => {
  //console.log("Service displaying");
  const selectedTypeId = serviceTypeSelect.value;
  filterPlots("service_type", selectedTypeId);

  // Filter services by service type
  const filteredServices = services.filter(
    (s) => s.service_type_name === selectedTypeId
  );
  //console.log(filteredServices);
  //console.log(selectedTypeId);

  // Populate services
  servicesSelect.innerHTML = '<option value="">-- Select Service --</option>';
  filteredServices.forEach((service) => {
    const option = document.createElement("option");
    option.value = service.service_name;
    option.textContent = service.service_name;
    servicesSelect.appendChild(option);
  });

  servicesDiv.style.display = filteredServices.length > 0 ? "block" : "none";
  plotTypesDiv.style.display = "none";
  // selectionCon.style.display = 'none';
  feesDisplay.style.display = "none";
});

// Runs if the a service was selected to show the Plot Type selection
servicesSelect.addEventListener("change", () => {
  const selectedServiceId = servicesSelect.value;
  displayFee(selectedServiceId);
  //console.log(fee);

  // Filter plot types by service
  const filteredPlotTypes = plotTypes.filter(
    (pt) => pt.service_name === selectedServiceId
  );

  //console.log(selectedServiceId);
  //console.log(filteredPlotTypes);

  // Populate plot types
  plotTypesSelect.innerHTML =
    '<option value="">-- Select Plot Type --</option>';
  filteredPlotTypes.forEach((pt) => {
    const option = document.createElement("option");
    option.value = pt.plot_type_name;
    option.textContent = pt.plot_type_name;
    plotTypesSelect.appendChild(option);
  });

  // if (selectedPlotTypeId.includes('Columbarium') || selectedPlotTypeId.includes('Apartment')) {

  plotTypesDiv.style.display = filteredPlotTypes.length > 0 ? "block" : "none";

  // } else {

  //     finalPlotDiv.style.display = 'block';
  // }
});

// Runs if the a Plot type to show the Plot selection
plotTypesSelect.addEventListener("change", () => {
  const selectedPlotTypeId = plotTypesSelect.value;
  filterPlots("plot_type", selectedPlotTypeId);
  //console.log(selectedPlotTypeId);
  // Filter plots by plot type
  const filteredPlots = plots.filter(
    (plot) => plot.plot_type_name === selectedPlotTypeId
  );
  if (
    selectedPlotTypeId.includes("Columbarium") ||
    selectedPlotTypeId.includes("Apartment")
  ) {
    //console.log("gridding plots");
    //console.log(filteredPlots);
    plot_name.innerHTML = selectedPlotTypeId;
    // Find max column and row numbers
    const maxColumn = Math.max(
      ...filteredPlots.map((plot) => plot.column_number)
    );
    const maxRow = Math.max(...filteredPlots.map((plot) => plot.row_number));

    // Create the grid container
    plotGrid.innerHTML = ""; // Clear previous content

    // Create the grid structure based on max row and column numbers
    for (let row = 1; row <= maxRow; row++) {
      const rowDiv = document.createElement("div");
      rowDiv.className = "row"; 

      // Create cells (columns) for this row
      for (let col = 1; col <= maxColumn; col++) {
        const plotInCell = filteredPlots.find(
          (plot) =>
            parseInt(plot.row_number) === row &&
            parseInt(plot.column_number) === col
        );
        const plotBox = document.createElement("div");

        //console.log(plotInCell);
        plotBox.className = "plot-cell"; 
        plotBox.id = plotInCell?.plot_code ?? "";

        // If a plot exists for this row and column, show its details
        if (plotInCell) {
          plotBox.className += ` plot-box ${
            plotInCell.availability === "1" ? "available" : "occupied"
          }`;
          plotBox.textContent = `${plotInCell.column_number},${plotInCell.row_number}`;
        } else {
          plotBox.className += " empty"; 
          plotBox.textContent = "N/A";
        }

        // Make the plotBox clickable
        plotBox.addEventListener("click", () => {
          // Change the selected value of finalPlotSelect to the id (plot_code) of the clicked plot
          finalPlotSelect.value = plotBox.id;
          const allPlotBoxes = document.querySelectorAll(".plot-cell");
          allPlotBoxes.forEach((box) => {
            box.classList.remove("highlighted"); // Remove highlight from all boxes
          });

          // Highlight the selected plotBox
          const selectedPlotBox = document.getElementById(plotBox.id);
          //console.log(selectedPlotBox);

          if (selectedPlotBox) {
            selectedPlotBox.classList.add("highlighted"); // Add the highlight class
            const selectedPlotCode = finalPlotSelect.value;
            const selectedServiceId = servicesSelect.value;

            displayFee(selectedServiceId, plotBox.id);
          }
          // Optionally, you can trigger the change event or any other action you want when the plot is selected
          // finalPlotSelect.dispatchEvent(new Event('change'));
        });

        rowDiv.appendChild(plotBox); // Add the plot or empty cell to the row
      }

      plotGrid.appendChild(rowDiv); // Add the row to the grid
    }

    // Populate the select dropdown with available plots
    finalPlotSelect.innerHTML = '<option value="">-- Select Plot --</option>';
    filteredPlots.forEach((plot) => {
      if (plot.availability === "1") {
        const option = document.createElement("option");
        option.value = plot.plot_code;
        option.textContent = ` ${plot.plot_code}`;
        finalPlotSelect.appendChild(option);
      }
    });
    finalPlotDiv.style.display = "block"; // Show the plot selection div
  } else {
    finalPlotSelect.innerHTML = '<option value="">-- Select Plot --</option>';
    filteredPlots.forEach((plot) => {
      if (plot.availability === "1") {
        const option = document.createElement("option");
        option.value = plot.plot_code;
        option.textContent = ` ${plot.plot_code}`;
        finalPlotSelect.appendChild(option);
      }
    });
    finalPlotDiv.style.display = "block";
  }

  // Display exclusive plots

  // selectionCon.style.display = 'none';

  // Display Fees
});

// Runs if the a Plot was selected to show the Columbarium and Apartment types Selevtion Div
finalPlotSelect.addEventListener("change", function () {
  const selectedPlotTypeId = plotTypesSelect.value;
  const selectedPlotCode = finalPlotSelect.value;
  const selectedServiceId = servicesSelect.value;

  displayFee(selectedServiceId, selectedPlotCode);
  // console.log(fee);
  if (
    selectedPlotTypeId.includes("Columbarium") ||
    selectedPlotTypeId.includes("Apartment")
  ) {
  } else {
    filterPlots("plot_code", selectedPlotCode);
  }

  console.log(selectedPlotCode);
  // Clear previous highlights
  const allPlotBoxes = document.querySelectorAll(".plot-cell");
  allPlotBoxes.forEach((box) => {
    box.classList.remove("highlighted"); // Remove highlight from all boxes
  });

  // Highlight the selected plotBox
  const selectedPlotBox = document.getElementById(selectedPlotCode);
  //console.log(selectedPlotBox);

  if (selectedPlotBox) {
    selectedPlotBox.classList.add("highlighted"); // Add the highlight class
  }
});
// ------------------------Function to display fees based on plot selection------------------------//
function displayFee(serviceName, plotCode) {
  // Define service categories based on service_name
  feesDisplay.style.display = "none";

  const chapelAndBasicServices = [
    "Chapel",
    "Burial / Exhumation / Restus",
    "Entrance / Transfer",
  ];
  const columbariumService = "Columbarium";
  const exclusiveAndApartmentServices = [
    "Exclusive Lot/Niches",
    "Apartment Niches",
  ];
  console.log(serviceName);
  console.log(plotCode);

  // Filter relevant fees based on the service name
  const relevantFees = fees.filter((fee) => fee.service_name === serviceName);
  console.log(relevantFees);
  let plotInfo = null;
  if (plotCode) {
    plotInfo = plotData?.filter((o) => o.plot_code === plotCode);
    console.log(plotInfo);

    if (exclusiveAndApartmentServices.includes(plotInfo[0]?.service_name)) {
      // For exclusive lots or apartments, match both service_id and tier
      const { service_name, tier } = plotInfo[0] ?? [];
      const matchingFee = relevantFees.find(
        (fee) =>
          fee.service_name.includes(service_name) && fee.tier.includes(tier)
      );
      console.log(matchingFee);
      console.log(service_name, tier);
      feesDisplay.style.display = "block";

      feesDetails.innerText = matchingFee
        ? "₱" + matchingFee.amount + " " + matchingFee?.duration ?? ""
        : "Fee not found";
      feesInput.value = matchingFee
        ? "₱" + matchingFee.amount + " " + matchingFee?.duration ?? ""
        : "Fee not found";
      feesCode.value = matchingFee.code;
      // return matchingFee ? matchingFee.amount : "Fee not found";
    } else if (plotInfo[0]?.service_name === columbariumService) {
      // For columbarium, match service_name, tier, and row
      const { service_name, tier, row_number } = plotInfo[0] ?? [];
      const matchingFee = relevantFees.find(
        (fee) =>
          fee.service_name.includes(service_name) &&
          fee.tier.includes(tier) &&
          fee.description.includes(row_number)
      );
      console.log(matchingFee);
      console.log(service_name, tier, row_number);
      feesDisplay.style.display = "block";

      feesDetails.innerText = matchingFee
        ? "₱" + matchingFee.amount + " " + matchingFee?.duration ?? ""
        : "Fee not found";
      feesInput.value = matchingFee
        ? "₱" + matchingFee.amount + " " + matchingFee?.duration ?? ""
        : "Fee not found";
      feesCode.value = matchingFee.code;

      // return matchingFee ? matchingFee.amount : "Fee not found";
    }
  } else if (chapelAndBasicServices.includes(serviceName)) {
    // For chapel and basic services, return the first matching fee amount
    feesDisplay.style.display = "block";

    feesDetails.innerText = relevantFees.length
      ? "₱" + relevantFees[0].amount + " " + relevantFees[0]?.duration ?? ""
      : "Fee not found";
    console.log(matchingFee);
    feesInput.value = relevantFees.length
      ? "₱" + relevantFees[0].amount + " " + relevantFees[0]?.duration ?? ""
      : "Fee not found";
    feesCode.value = relevantFees[0].code;

    // return relevantFees.length ? relevantFees[0].amount : "Fee not found";
  } else if (!chapelAndBasicServices.includes(serviceName) && !plotCode) {
    feesDisplay.style.display = "block";

    feesDetails.innerText = "Please Select a Plot first!";
  } else {
    // Default case: If service_name does not match any category
    // else return "Invalid service";
    feesDisplay.style.display = "block";

    feesDetails.innerText = "Invalid service";
  }
}

//------------------------ Filter function ------------------------//
function filterPlots(type, value) {
  if (!["service_type", "plot_type", "plot_code"].includes(type)) {
    //console.error("Invalid type provided");
    return;
  }

  // Map type to respective data field
  const typeToField = {
    service_type: "service_type_name",
    plot_type: "plot_type_name",
    plot_code: "plot_code",
  };

  // Filter the data
  plotDataFilter = plotData.filter((plot) => plot[typeToField[type]] === value);
  filteredPlot();
  //console.log(plotDataFilter); // Output the filtered data
  // return plotDataFilter; // Return filtered data
}
