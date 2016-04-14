<h3>Ticket History</h3>
<ol class="timeline">
  <li>
    Created <span class="smalltxt highlight">01/01/2016</span>
  </li>
  <li>
    Assigned <span class="smalltxt highlight">01/01/2016</span>
  </li>
  <li>
    Update <span class="smalltxt highlight">01/01/2016</span>
  </li>
</ol>

<style>
ol.timeline {
	position: relative;
	display: block;
	margin: 150px 100px;
	height: 2px;
	background: #ccc;
}
ol.timeline::before,
ol.timeline::after {
	content: "";
	position: absolute;
	top: -7px;
	display: block;
	width: 0;
	height: 0;
  border-radius: 0px;
	border: 8px solid #ccc;
}
ol.timeline::before {
	left: -5px;
}
.timeline li {
	position: relative;
	top: -79px;
	display: inline-block;
	float: left;
	width: 150px;
	transform: rotate(-45deg);
	font-size: 0.8rem;
}
.timeline li::before {
	content: "";
	position: absolute;
	top: 5px;
	left: -29px;
	display: block;
	width: 8px;
	height: 8px;
	border-radius: 10px;
	background: #577d6a;
}
.timeline li:first-child::before {
  content: "";
	position: absolute;
	top: 0;
	left: -29px;
	display: block;
	border: none;
	background: transparent;
}

</style>
