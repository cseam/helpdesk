
<div id="timeline">
<h3>Timeline</h3>
  <ul class="timeline">
    <li>
      <div class="timeline-badge badge-1"></div>
      <div class="timeline-panel">
        <div class="timeline-heading">- ticket opened: <?php echo date("d/m/Y H:i", strtotime($ticketDetails["opened"]));?></div>
      </div>
    </li>
    <?php
    $doc = new DOMDocument();
    $doc->loadHTML($ticketDetails["details"]);
    $items = $doc->getElementsByTagName('h3');
        foreach ($items as $tag1)
        { ?>
          <li>
            <div class="timeline-badge badge-1"></div>
            <div class="timeline-panel">
              <div class="timeline-heading">- <?php echo $tag1->nodeValue; ?></div>
            </div>
          </li>
    <?php } ?>
    <li>
      <div class="timeline-badge badge-1"></div>
      <div class="timeline-panel">
        <div class="timeline-heading">- last update: <?php echo date("d/m/Y H:i", strtotime($ticketDetails["lastupdate"]));?></div>
      </div>
    </li>
  </ul>
</div>

<style>
#timeline {
  background: transparent;
  height: 83%;
  overflow: auto;
}
.timeline {
  list-style: none;
  padding: 20px 0 20px;
  position: relative;
}
.timeline:before {
  top: 0;
  bottom: 0;
  position: absolute;
  content: " ";
  width: 2px;
  background-color: #ccc;
  right: 100px;
  margin-left: -1.5px;
}
.timeline > li {
  margin-bottom: 5px;
  position: relative;
}
.timeline > li:before,
.timeline > li:after {
  content: " ";
  display: table;
}
.timeline > li:after {
  clear: both;
}
.timeline > li > .timeline-badge {
  position: absolute;
  z-index: 100;
}
.timeline-badge {
  background-color: white;
  width: 8px !important;
  height: 8px !important;
  right: 95px !important;
  top: 6px !important;
  border-radius: 100%;
}
.badge-1 {
  border: 2px solid rgb(100, 125, 106) !important;
}
.badge-4 {
  border: 2px solid rgb(194, 10, 13) !important;
}
.badge-3, .badge-5  {
  border: 2px solid rgb(194, 151, 9) !important;
}
.badge-2 {
  border: 2px solid rgb(0, 25, 91) !important;
}
.timeline-heading {
  font-family: 'verlag', Arial;
  font-size: 0.8rem;
  color: #6b6b6b;
  text-transform: none;
  padding: 5px 0;
  text-decoration: none;
  font-weight: 150;
}
</style>
