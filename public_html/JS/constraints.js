//To solve- Issue with ID's
console.log('Opening constraints.js');
/*Notes
ESIC(Employee): >15k NA, <15k 1.75% Gross
PF: 12%(Gross-HRA), max upto 15k
PT: 0<Gross<7.5k=nil, 7.5k<Gross<10k=175, Gross>10k=200(300 in feb)
Leave: 21 days in a year
HRA 30% of Basic if Gross>15k
Else 0*/



function HRA()
{
	var gross = document.getElementByID('').value;
	if(gross>15000)
	{
		document.getElementByID(hra'').value=0.3*(document.getElementByID(basic'')).value;
	}
	else
	{
		document.getElementByID(hra'').value=0;
	}	
}


function no_leaves()
{
	document.getElementsByTagName('leaves').value=21;
}

function PT()
{   var pt;
	var gross = document.getElementByID('').value;
	if(gross<7500)
	{
       pt=0;
	}
	else if(gross>=7500 && gross<10000)
	{
		pt=175;
	}
	else if(gross>=10000)
	{
		pt=200;
		var d=new Date();
		if((d.getMonth() + 1)==2)
		{
			pt=300;
		}
	}
	document.getElementByID(PT'').value=pt;


}
function PF()
{
	
	var gross_hra=document.getElementByID(Gross-HRA'');
    var pf=0.12*gross_hra;
    if(pf>15000)
      pf=15000;
    document.getElementByID(PF'').value=pf;

}

function ESIC()
{   
	var esic;
	var gross = document.getElementByID('').value;
  	if(gross>15000)
  	{
  		esic=0;
  	}
  	else
  	{
  		esic=0.0175*gross;
  	}
  	document.getElementByID(ESIC'').value=esic;
}
