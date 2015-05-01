<?php
session_start();
require ("header.php");
$admin = isAdmin();
$conn = connect();
isLoggedIn( $conn );

?>
<div class="container">
	<h1>Search For Profiles</h1>
</div>

<div class="jumbotron container" style="padding-top:24px;">
<div class="container">
    <div class="row">    
        <div class="col-sm-8 col-sm-offset-2">
		    <div class="input-group">
                <div class="input-group-btn search-panel">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    	<span id="search_concept">Filter by</span> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#donorProfile">Donor Profiles</a></li>
                      <li><a href="#customerProfile">Customer Profiles</a></li>
                      <?php if($admin){ ?>
                      <li><a href="#employeeProfile">Employee Profiles</a></li>
                      <?php } ?>
                    </ul>
                </div><!--input group btn/search panel-->
                <input type="hidden" name="search_param" value="all" id="search_param">         
                <input type="text" class="form-control" id="searchField" name="x" placeholder="Search Profiles">
                <span class="input-group-btn">
                    <button class="btn btn-default" id="seachBtn" type="button"><span class="glyphicon glyphicon-search"></span></button>
                </span>
            </div><!--input group-->
            <p class="filterError" style="color:#A94442;font-size:16px;display:none;">Please select a filter</p>
        </div><!--col xs-->
	</div><!--row-->
</div><!--end container-->
	<div class="center-block container">

		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>

		<div class="well">
		
			<ul class="nav nav-tabs">
				<li class="active liTab"><a data-toggle="tab" href="#listWell">List</a></li>
				<li class="liTab"><a data-toggle="tab" href="#profileWell">Profile</a></li>
			</ul>
			<div class="tab-content">
				<div id="listWell" class="tab-pane active"></div>
				<div id="profileWell" class="tab-pane"></div>
			</div><!--end tab-content-->
      
		</div><!--end well-->
		
	</div>
</div>
<script>

function editPro(){
	//save all current info into formHTML
	var formHTML = $( '#profileWell:first' ).html();
	
	//can now edit inputs & changed buttons
	$('input').removeAttr('readonly');
	$( '.editProfile' ).toggle();
	$( '#changeBtn' ).toggle();
	
	//if cancel is clicked
	$( '#cancelEdit' ).click(function(){
		//put previous info back & change to edit btn
		$( '.editProfile' ).toggle();
		$( '#changeBtn' ).toggle();
		$( '#profileWell:first' ).html(formHTML);
/* 		$('input').attr('readonly'); */
	});//end cancel click
	
	$( '#submitEdit' ).click(function(){
		var fname = $( '#fname' ).val();
		var lname = $( '#lname' ).val();
		var addr = $( '#address' ).val();
		var email = $( '#email' ).val();
		var id = $( this ).attr( 'name' );
		
		console.log(fname+'   '+lname+'  '+addr+'  '+email+'  '+id);
		
		var jqxhr = $.ajax( "functions.php?action=subEditDon&fname="+fname+"&lname="+lname+"&address="+addr+"&email="+email+"&id="+id)
		.done(function(responseText){
			profileWell.innerHTML = responseText;
			grabProfile();
		}).fail(function(){
			//alert( "error" );
		}).always(function(){
			//alert( "complete" );
		});//end ajax
	});


}//end editPro function


function addDonor(){
	//get all info in input to insert into database
	//is email right column name?
	var fname = $( '#fname' ).val();
	var lname = $( '#lname' ).val();
	var addr = $( '#address' ).val();
	var email = $( '#email' ).val();
	
	//call getDonProfile after inserting into database?
	var jqxhr = $.ajax( "functions.php?action=addDonPro&fname="+fname+"&lname="+lname+"&address="+addr+"&email="+email)
		.done(function(responseText){
			profileWell.innerHTML = responseText;
			grabProfile();
		}).fail(function(){
			//alert( "error" );
		}).always(function(){
			//alert( "complete" );
		});//end ajax
}//end add donor function

function addCust(){
	//get all info in input to insert into database
	//is email right column name?
	var fname = $( '#fname' ).val();
	var lname = $( '#lname' ).val();
	var addr = $( '#address' ).val();
	var aff = $( '#aff' ).val();
	
	//call getDonProfile after inserting into database?
	var jqxhr = $.ajax( "functions.php?action=addCusPro&fname="+fname+"&lname="+lname+"&address="+addr+"&aff="+aff)
		.done(function(responseText){
			profileWell.innerHTML = responseText;
			grabProfile();
		}).fail(function(){
			//alert( "error" );
		}).always(function(){
			//alert( "complete" );
		});//end ajax
}//end add donor function

function cancelAddDon(){
	
	var jqxhr = $.ajax( "functions.php?action=getDonProfile&id=null")
	       .done(function(responseText){
	        profileWell.innerHTML = responseText;
	       }).fail(function(){
	        //alert( "error" );
	       }).always(function(){
	        //alert( "complete" );
	       });//end ajax
}

function cancelAddCus(){
	
	var jqxhr = $.ajax( "functions.php?action=getCusProfile&id=null")
	       .done(function(responseText){
	        profileWell.innerHTML = responseText;
	       }).fail(function(){
	        //alert( "error" );
	       }).always(function(){
	        //alert( "complete" );
	       });//end ajax
}

function cancelAddEmp(){
	
	var jqxhr = $.ajax( "functions.php?action=getEmpProfile&id=null")
	       .done(function(responseText){
	        profileWell.innerHTML = responseText;
	       }).fail(function(){
	        //alert( "error" );
	       }).always(function(){
	        //alert( "complete" );
	       });//end ajax
}

function sureAddDon(){
	
	var fname = $( '#fname' ).val();
	var lname = $( '#lname' ).val();
	var addr = $( '#address' ).val();
	var email = $( '#email' ).val();
	
	var jqxhr = $.ajax( "functions.php?action=sureAdd&fname="+fname+"&lname="+lname+"&address="+addr+"&email="+email)
		.done(function(responseText){
			profileWell.innerHTML = responseText;
			grabProfile();
		}).fail(function(){
			//alert( "error" );
		}).always(function(){
			//alert( "complete" );
		});//end ajax
}

function sureAddCus(){
	
	var fname = $( '#fname' ).val();
	var lname = $( '#lname' ).val();
	var addr = $( '#address' ).val();
	var aff = $( '#aff' ).val();
	
	var jqxhr = $.ajax( "functions.php?action=sureAddCustomer&fname="+fname+"&lname="+lname+"&address="+addr+"&aff="+aff)
		.done(function(responseText){
			profileWell.innerHTML = responseText;
			grabProfile();
		}).fail(function(){
			//alert( "error" );
		}).always(function(){
			//alert( "complete" );
		});//end ajax
}


//if enter was pressed instead of clicking the icon
/*
$('#searchField').keypress(function (e) {
 var key = e.which;
 if(key == 13)  // the enter key code
  {
    $('button[type = button]').click();
    return false;  
  }
});
*/

/*
var tabClass = $( '.nav-tabs:last' ).hasClass('active');
function tabClassActive(){
console.log(tabClass);
if(tabClass == true){
	$('.liTab').toggleClass( 'active' );
	$('.tab-pane').toggleClass( 'active' );
	 }
}
*/

$("#seachBtn").click(function(){

//looking at profile, switch filter, should go back to list tab
/* 	if($('li').val( 'List' ).attr('class', 'active' )} */

	var sea = $("#search_concept").text();
	var seaField = $("#searchField").val();
	var b_error = false;
	
	//Displays error message if no filter was chosen
	if(sea == "Filter by"){
		$(".filterError").toggle(true);
		return;
	}else{
		$(".filterError").toggle(false);
	}
	
	//if donor, customer, or employee && searchField = empty
	if(seaField == ""){
		var a_sea = sea.split(" ");
		sea = a_sea[0].toLowerCase();
	        var jqxhr = $.ajax( "functions.php?action=dceSearch&type="+sea )
	        .done(function(responseText){
	        
		        listWell.innerHTML = responseText;
		        grabProfile();
		        /* tabClassActive(); */
	        }).fail(function(){
		        //alert( "error" );
	        }).always(function(){
		        //alert( "complete" );
	        });
		
	}//end if
	
	//if donor, customer, or employee && searchField != empty
	if(seaField != ""){
		var a_sea = sea.split(" ");
		sea = a_sea[0].toLowerCase();
		//sanitize search field input!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		var jqxhr = $.ajax( "functions.php?action=dceLikeSearch&type="+sea+"&likeType="+seaField)
	        .done(function(responseText){
		        listWell.innerHTML = responseText;
		        grabProfile();
	        }).fail(function(){
		        //alert( "error" );
	        }).always(function(){
		        //alert( "complete" );
	        });
	}//end dceLikeSearch
	
});//end search function

//changes table to search depending on value of filter
$(document).ready(function(e){
    $('.search-panel .dropdown-menu').find('a').click(function(e) {
		e.preventDefault();
		var param = $(this).attr("href").replace("#","");
		var concept = $(this).text();
		$('.search-panel span#search_concept').text(concept);
		$('.input-group #search_param').val(param);
	});
});

//grab id from name in list
function grabProfile(){
	$('.grabEmp').click(
		function(){		
			var jqxhr = $.ajax( "functions.php?action=getEmpProfile&id="+ (this.id))
		        .done(function(responseText){
			        profileWell.innerHTML = responseText;
		        }).fail(function(){
			        //alert( "error" );
		        }).always(function(){
			        //alert( "complete" );
			        $('.liTab').toggleClass( 'active' );
			        $('.tab-pane').toggleClass( 'active' );
		        });//end ajax
	});//end click
	
	$('.grabDon').click(
		function(){
		
			var jqxhr = $.ajax( "functions.php?action=getDonProfile&id="+ (this.id))
		        .done(function(responseText){
			        profileWell.innerHTML = responseText;
		        }).fail(function(){
			        //alert( "error" );
		        }).always(function(){
			        //alert( "complete" );
			        $('.liTab').toggleClass( 'active' );
			        $('.tab-pane').toggleClass( 'active' );
		        });//end ajax
/* 		        console.log(tabClass); */
	});//end click
	
	$('.grabCus').click(
		function(){
			var jqxhr = $.ajax( "functions.php?action=getCusProfile&id="+ (this.id))
		        .done(function(responseText){
			        profileWell.innerHTML = responseText;
		        }).fail(function(){
			        //alert( "error" );
		        }).always(function(){
			        //alert( "complete" );
			        $('.liTab').toggleClass( 'active' );
			        $('.tab-pane').toggleClass( 'active' );
		        });//end ajax
	});//end click
	
	$('#newCusBtn').click(
		function(){
			
			var jqxhr = $.ajax( "functions.php?action=getCusProfile&id=null")
		        .done(function(responseText){
			        profileWell.innerHTML = responseText;
		        }).fail(function(){
			        //alert( "error" );
		        }).always(function(){
			        //alert( "complete" );
			        $('.liTab').toggleClass( 'active' );
			        $('.tab-pane').toggleClass( 'active' );
		        });//end ajax

	});//end click
	
	$('#newDonBtn').click(
		function(){
			
			var jqxhr = $.ajax( "functions.php?action=getDonProfile&id=null")
		        .done(function(responseText){
			        profileWell.innerHTML = responseText;
		        }).fail(function(){
			        //alert( "error" );
		        }).always(function(){
			        //alert( "complete" );
			        $('.liTab').toggleClass( 'active' );
			        $('.tab-pane').toggleClass( 'active' );
		        });//end ajax

	});//end click
	
	$('#newEmpBtn').click(
		function(){
			
			var jqxhr = $.ajax( "functions.php?action=getEmpProfile&id=null")
		        .done(function(responseText){
			        profileWell.innerHTML = responseText;
		        }).fail(function(){
			        //alert( "error" );
		        }).always(function(){
			        //alert( "complete" );
			        $('.liTab').toggleClass( 'active' );
			        $('.tab-pane').toggleClass( 'active' );
		        });//end ajax

	});//end click
	
}//end grabProfile function
</script>
<?php require("footer.html"); ?>