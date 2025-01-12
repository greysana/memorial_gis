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
const mapSearch = document.getElementById("map_search");
const mapSearchBtn = document.getElementById("search_map");

const plotGrid = document.getElementById("plotGrid");

fetchPlots();

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
    const response = await fetch("api/get_plots.php");
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
mapSearch.addEventListener("input", () => {
  filterPlots(mapSearch.value);
  const detailsContainer = document.getElementById("details-container");
  const selectionCon = document.getElementById("selectionCon");
  plotGrid.innerHTML = "";
  detailsContainer.innerHTML = "";
});
mapSearchBtn.addEventListener("click", () => {
  showDetails(plotDataFilter);
});
//------------------------ Filter function ------------------------//
function filterPlots(value) {
  // Filter the data
  plotDataFilter = plotData.filter(
    (plot) =>
      plot?.plot_code?.toLowerCase()?.includes(value.toLowerCase()) || plot?.deceased_name?.toLowerCase()?.includes(value?.toLowerCase())
  );
  console.log(plotDataFilter);
  console.log(plotData);

  filteredPlot();
}
function showDetails() {
  const detailsContainer = document.getElementById("details-container");
  const selectionCon = document.getElementById("selectionCon");
  plotGrid.innerHTML = "";
  detailsContainer.innerHTML = "";
  console.log(plotDataFilter[0]);
  if (plotDataFilter[0]?.length < 0 || plotDataFilter[0] === undefined) {
    const detailsTitle = document.createElement("p");
    detailsTitle.textContent =
      "The Deceased Name or the Plot Code does not exist on our Database, Please Try Searching again.";
    detailsContainer.appendChild(detailsTitle);
  } else {
    console.log(plotDataFilter);

    // Clear existing details if present
    const existingDetails = selectionCon.querySelector(".details-container");
    if (existingDetails) {
      existingDetails.remove();
    }

    // Create a details container for the single plot

    const detailsTitle = document.createElement("h4");
    detailsTitle.textContent = "Plot Details:";
    detailsContainer.appendChild(detailsTitle);
    const mapBtnWrap = document.createElement("div");
    mapBtnWrap.className = "map-btn-wrap";
    const cleanedString = plotDataFilter[0].geo_position.trim();
    let geo_position = JSON.parse(cleanedString);

    const plotDetails = document.createElement("div");
    plotDetails.className = "details-wrap";
    if (
      !plotDataFilter[0]?.service_name.includes("Apartment") &&
      !plotDataFilter[0]?.service_name.includes("Columbarium")
    ) {
      mapBtnWrap.innerHTML = `
            Locate with Google Maps
            <a class="map-btn" href="https://www.google.com/maps?q=${geo_position[0]},${geo_position[1]}">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/39/Google_Maps_icon_%282015-2020%29.svg/2048px-Google_Maps_icon_%282015-2020%29.svg.png" alt="Google Map button"/>
            </a>
            `;
      detailsContainer.appendChild(mapBtnWrap);
      plotDetails.innerHTML = `
          <span>
          <strong>
          Deceased_name:
          </strong> ${plotDataFilter[0]?.deceased_name ?? "Empty"}
          </span>
          <span>
          <strong>
          Plot Code:
          </strong>
          ${plotDataFilter[0]?.plot_code}
          </span>

          <span>
          <strong>
          Service:
          </strong>${plotDataFilter[0]?.service_name}
          </span>
          <span>
          <strong>
          Availability:
          </strong>
          ${plotDataFilter[0]?.availability === "1" ? "Available" : "Occupied"}
          </span>
          `;
            } else {
              mapBtnWrap.innerHTML = `
            Locate with Google Maps
            <a class="map-btn" href="https://www.google.com/maps?q=${geo_position[0]}">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/39/Google_Maps_icon_%282015-2020%29.svg/2048px-Google_Maps_icon_%282015-2020%29.svg.png" alt="Google Map button"/>
            </a>
            `;
              detailsContainer.appendChild(mapBtnWrap);
              plotDetails.innerHTML = `
          <span>
          <strong>
          Deceased_name:
          </strong> ${plotDataFilter[0]?.deceased_name ?? "Empty"}
          </span>
          <span>
          <strong>
          Plot Code:
          </strong>
          ${plotDataFilter[0]?.plot_code}
          </span>

          <span>
          <strong>
          Service:
          </strong>${plotDataFilter[0]?.service_name}
          </span>

          <span>
          <strong>
          Row:
          </strong>
          ${plotDataFilter[0]?.row_number},  <strong>
          Column:
          </strong>
        ${plotDataFilter[0]?.column_number},
          </span>
          <span>
          <strong>
          Availability:
          </strong>
          ${plotDataFilter[0]?.availability === "1" ? "Available" : "Occupied"}
          </span>
          `;
    }

    detailsContainer.appendChild(plotDetails);

    // Append the details container below the grid
    selectionCon.appendChild(detailsContainer);
    if (
      plotDataFilter[0]?.service_name.includes("Columbarium") ||
      plotDataFilter[0]?.service_name.includes("Apartment")
    ) {
      let filteredPlots = plotData.filter((plot) =>
        plot?.service_name?.includes(plotDataFilter[0]?.service_name)
      );
      console.log("gridding plots");
      console.log(filteredPlots);
      // plot_name.innerHTML = selectedPlotTypeId;
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

          rowDiv.appendChild(plotBox); // Add the plot or empty cell to the row
        }

        plotGrid.appendChild(rowDiv); // Add the row to the grid
      }
      const allPlotBoxes = document.querySelectorAll(".plot-cell");
      allPlotBoxes.forEach((box) => {
        box.classList.remove("highlighted"); // Remove highlight from all boxes
      });

      // Highlight the selected plotBox
      const selectedPlotBox = document.getElementById(
        plotDataFilter[0]?.plot_code
      );
      //console.log(selectedPlotBox);

      if (selectedPlotBox) {
        selectedPlotBox.classList.add("highlighted"); // Add the highlight class
      }
    }
  }
}
