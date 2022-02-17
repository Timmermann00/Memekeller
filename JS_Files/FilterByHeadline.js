function ProccesInputData()
{
    var filtertable = document.getElementById('filtertable');
    if(document.getElementById('filterinput').value !== "")
    {
        var filterreq = new XMLHttpRequest();
    
        filterreq.onreadystatechange=function (){
            if(filterreq.readyState===4 && filterreq.status===200)
            {
                DeleteTableContent(filtertable);
                var res = JSON.parse(filterreq.responseText);
            
                for(let i=0;i<res.length;i++)
                {
                    var a = document.createElement('a');
                    a.href="SingleView.php?id="+ res[i].id + "&action=show";
                    var img = document.createElement('img');
                    img.src = res[i].file_path;
                    img.classList.add('Filterimg');
                    a.appendChild(img);
                    
                    var row = filtertable.insertRow(filtertable.rows.length);
                    var cell = row.insertCell(0);
                    cell.appendChild(a);
                }
            }
            else if(filterreq.status===404)
            {
                alert("No server response");
            }
            
        };
        
        filterreq.open("POST","../Ajax-phpScript/FilterForHeadline.php?",true);
        filterreq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        filterreq.send("headline="+document.getElementById('filterinput').value);
    }
    else
    {
        DeleteTableContent(filtertable);
    }
    
}

function DeleteTableContent(tableobj)
{
    if(tableobj.rows.length!==0)
    {
        tableobj.innerHTML="";
    }
}


