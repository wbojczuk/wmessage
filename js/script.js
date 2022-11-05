const localUserData = userData;
const nonfriendIcons = document.querySelectorAll(".fl-nonfriend");
const friendExpandedWrapper = document.getElementById("friendExpandedWrapper");
const friendExpanded = document.getElementById("friendExpanded");

nonfriendIcons.forEach((icon)=>{
    icon.addEventListener("click", (evt)=>{
        // ON ICON CLICK
        const currentUserData = getUserData(evt.target.title);
        friendExpanded.innerHTML = currentUserData[0] + "<br>" + currentUserData[1] + "<br>" + currentUserData[2] + "<br>";

        const addFriendLink = document.createElement("a");
        addFriendLink.href = `./index.php?addfriend=${currentUserData[0]}`;
        addFriendLink.textContent = "Add Friend";
        friendExpanded.appendChild(addFriendLink);
        
        friendExpandedWrapper.style.transform = "translateY(0)";

    });
});


// Send Wrapper Back Up

let expandedDown = false;
friendExpanded.addEventListener("mousedown",()=>{
    expandedDown = true;
});
window.addEventListener("mouseup",()=>{
    expandedDown = false;
});

window.addEventListener("mousedown",()=>{
    if(!expandedDown){
        friendExpandedWrapper.style.transform = "translateY(-100%)";
    }
});

// Functions

function getUserData(name){
    let retval = [];
    localUserData.forEach((user)=>{
        if(user[0] == name){
            retval = user;
        }
    });
    return retval;
}