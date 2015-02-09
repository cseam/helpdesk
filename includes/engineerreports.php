		<form action="<?php echo($_SERVER['PHP_SELF']);?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">View All Tickets</button>
		<input type="hidden" id="report" name="report" value="1" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-allcalls@2x.png" width="24" height="25" class="icon" alt="View All ticket" title="View All ticket" />
		</form>
		<form action="<?php echo($_SERVER['PHP_SELF']);?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">View Oldest Ticket</button>
		<input type="hidden" id="report" name="report" value="2" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-oldestcall@2x.png" width="24" height="25" class="icon" alt="View Oldest ticket" title="View Oldest ticket" />
		</form>
		<form action="<?php echo($_SERVER['PHP_SELF']);?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">Engineer Work Rate</button>
		<input type="hidden" id="report" name="report" value="4" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-workrate@2x.png" width="24" height="25" class="icon" alt="Engineer Work Rate" title="Engineer Work Rate"/>
		</form>
		<form action="<?php echo($_SERVER['PHP_SELF']);?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">Punchcard in/out</button>
		<input type="hidden" id="report" name="report" value="6" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-punchcard@2x.png" width="24" height="25" class="icon" alt="Punch Card" title="Punch Card" />
		</form>
		<form action="<?php echo($_SERVER['PHP_SELF']);?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">Emerging Issues</button>
		<input type="hidden" id="report" name="report" value="7" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-issues@2x.png" width="24" height="25" class="icon" alt="Emerging Issues" title="Emerging Issues"/>
		</form>
		<form action="<?php echo($_SERVER['PHP_SELF']);?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">Search Tickets</button>
		<input type="hidden" id="report" name="report" value="8" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-search@2x.png" width="24" height="25" class="icon" alt="Search tickets" title="Search tickets"/>
		</form>
		<form action="<?php echo($_SERVER['PHP_SELF']);?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">Add Change Control</button>
		<input type="hidden" id="report" name="report" value="10" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-addchangecontrol@2x.png" width="24" height="25" class="icon" alt="Add Change Control" title="Add Change Control"/>
		</form>
		<form action="<?php echo($_SERVER['PHP_SELF']);?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">View Change History</button>
		<input type="hidden" id="report" name="report" value="11" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-changecontrol@2x.png" width="24" height="25" class="icon" alt="View Change Control" title="View Change Control"/>
		</form>
		<form action="<?php echo($_SERVER['PHP_SELF']);?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">IT Reception Screen</button>
		<input type="hidden" id="report" name="report" value="14" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-digitalscreen@2x.png" width="24" height="25" class="icon" alt="IT Screen" title="IT Screen"/>
		</form>
		<form action="<?php echo($_SERVER['PHP_SELF']);?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">Lockers</button>
		<input type="hidden" id="report" name="report" value="16" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-lockers@2x.png" width="24" height="25" class="icon" alt="Lockers" title="Lockers" />
		</form>
<script type="text/javascript">
     $('.reportlist').submit(function(e) {
    	$.ajax(
			{
				type: 'post',
				url: '/includes/managerviewreport.php',
				data: $(this).serialize(),
				beforeSend: function()
				{
				$('#ajax').html('<img src="/images/ICONS-spinny.gif" alt="loading" class="loading"/>');
    			},
				success: function(data)
				{
				$('#ajax').html(data);
    			},
				error: function()
				{
				$('#ajax').html('error loading data, please refresh.');
    			}
			});
       e.preventDefault();
       return false;
    });
</script>