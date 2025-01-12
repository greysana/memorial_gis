<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaflet Map with Polygon and Marker Toggle</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/map.css">


    <style>

    </style>
</head>

<body>
    <div class="container">
        <div class="container-flex">
            <div class="contents">
                <div class="controls">
                    <button id="togglePolygon">Toggle Polygon</button>
                    <button id="toggleMarker">Toggle Marker</button>
                </div>
                <div id="map"></div>
                <div class="selection-con" id="selectionCon">
                    <!-- Columbarium and Apartment Grid -->
                    <h3 id='plot_name'></h3>
                    <div id="plotGrid" class="plotGrid">a</div>
                </div>
            </div>
            <div class="form">
                <h2>Reservation Form</h2>
                <p>Please fill in the required information to proceed.</p>
                <h2>Service Selection</h2>

                <!-- Service Type Selection -->
                <label for="serviceType">Select Service Type:</label>
                <select id="serviceType" name="serviceType" required>
                    <option value="">-- Select Service Type --</option>
                </select>

                <!-- Services Selection -->
                <div id="servicesDiv" style="margin-top: 10px; display: none;">
                    <label for="services">Select Service:</label>
                    <select id="services" name="services">
                        <option value="">-- Select Service --</option>
                    </select>
                </div>

                <!-- Plot Types Selection -->
                <div id="plotTypesDiv" style="margin-top: 10px; display: none;">
                    <label for="plotTypes">Select Plot Type:</label>
                    <select id="plotTypes" name="plotTypes">
                        <option value="">-- Select Plot Type --</option>
                    </select>
                </div>


                <!-- Final Plot Selection -->
                <div id="finalPlotDiv" style="margin-top: 10px; display: none;">
                    <label for="finalPlot">Select Plot:</label>
                    <select id="finalPlot" name="finalPlot">
                        <option value="">-- Select Plot --</option>
                    </select>
                </div>
                <!-- Fees Display -->
                <div id="feesDisplay" style="margin-top: 10px; display: none;">
                    <h3>Fees:</h3>
                    <div id="feesDetails"></div>
                </div>
                <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="js/map.js"></script>
    <script>



    </script>
</body>

</html>