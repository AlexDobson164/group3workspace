<link rel="stylesheet" href="./css/addChart.css">

<div class="interaction-menu">
      <button id="addChart">Add Chart</button>
      <button id="newReport">New Report</button>
    </div>

    <div class="menu-container" style="display: none;">
      <form action="">
        <label for="select-dataset">Select Dataset:</label>
        <select id="select-dataset" name="select-dataset">
          <option value="percentage-legal-compliance">Legal Compliance Percentage</option>
          <option value="legal-red-tasks">Legal Red Tasks Total</option>
          <option value="legal-amber-tasks">Legal Amber Tasks Total</option>
        </select>

        <label for="select-graphtype">Select Graph Type:</label>
        <select id="select-graphtype" name="select-graphtype">
          <option value="">Graphs</option>
        </select>

        <label for="graph-caption">Graph Caption:</label>
        <input type="text" id="graph-caption" name="graph-caption">

        <label for="graph-subcaption">Graph Subcaption:</label>
        <input type="text" id="graph-subcaption" name="graph-subcaption">

        <button type="button" id="addInput" onclick="addDataPoint()">Add Data Point</button>

        <div id="data-point-container"></div>

        <input type="submit" value="Submit" id="form-button">
      </form>
    </div>
