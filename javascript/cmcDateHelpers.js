//javascript functions to format date strings

var cmcArrShortMonthNames = [
                        "Jan",
                        "Feb",
                        "Mar",
                        "Apr",
                        "May",
                        "Jun",
                        "Jul",
                        "Aug",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dec",
                        ];

var cmcArrMonthNames = [
                        "January", 
                        "February", 
                        "March",
                        "April", 
                        "May", 
                        "June", 
                        "July",
                        "August", 
                        "September", 
                        "October",
                        "November", 
                        "December"
                        ];

//date string format YYYY-MM-DD to 8 Dec
//http://www.w3schools.com/jsref/jsref_obj_date.asp
function cmcDDMonFormat(strDate) {
	var objDate = new Date(strDate.split(' ')[0]);
	objDate.setTime(objDate.getTime() + objDate.getTimezoneOffset()*60*1000);
	return objDate.getDate() + " " + cmcArrShortMonthNames[objDate.getMonth()];
    //var dateArr = strDate.split('-');
	//return dateString + " HI!";
}

//date string format YYYY-MM-DD to 8 Dec 2016
//http://www.w3schools.com/jsref/jsref_obj_date.asp
function cmcDDMonYYYYFormat(strDate) {
	var objDate = new Date(strDate.split(' ')[0]);
	objDate.setTime(objDate.getTime() + objDate.getTimezoneOffset()*60*1000);
	 return objDate.getDate() + " " + cmcArrShortMonthNames[objDate.getMonth()]  + " " + objDate.getFullYear();
  //var dateArr = strDate.split('-');
	//return dateString + " HI!";
}




//date string format YYYY-MM-DD to 8 December
//http://www.w3schools.com/jsref/jsref_obj_date.asp
function cmcDDMonthFormat(strDate) {
	var objDate = new Date(strDate.split(' ')[0]);
	objDate.setTime(objDate.getTime() + objDate.getTimezoneOffset()*60*1000);
	 return objDate.getDate() + " " + cmcArrMonthNames[objDate.getMonth()];
  //var dateArr = strDate.split('-');
	//return dateString + " HI!";
}

//date string format YYYY-MM-DD to 8 December
//http://www.w3schools.com/jsref/jsref_obj_date.asp
function cmcDDMonthYYYYFormat(strDate) {
	var objDate = new Date(strDate.split(' ')[0]);
	objDate.setTime(objDate.getTime() + objDate.getTimezoneOffset()*60*1000);
	 return objDate.getDate() + " " + cmcArrMonthNames[objDate.getMonth()]  + " " + objDate.getFullYear();
//var dateArr = strDate.split('-');
	//return dateString + " HI!";
}
