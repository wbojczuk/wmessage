const localUserData = userData;
const localCurrentUser = currentUser;
const localFriendRequests = friendRequests;
const localFriends = currentFriends;

const nonfriendIcons = document.querySelectorAll(".fl-nonfriend");
const friendExpandedWrapper = document.getElementById("friendExpandedWrapper");
const friendExpanded = document.getElementById("friendExpanded");
const friendExpandedPFP = friendExpanded.querySelector(".friend-expanded-pfp");
const friendExpandedName = friendExpanded.querySelector(".friend-expanded-name");
const friendExpandedDesc = friendExpanded.querySelector(".friend-expanded-desc");
const friendExpandedLink = friendExpanded.querySelector(".friend-expanded-add-friend");

const friendIcons = document.querySelectorAll(".fl-friend");

const mailExpandedWrapper = document.getElementById("mailExpandedWrapper");
const mailExpanded = document.getElementById("mailExpanded");
const mailIcon = document.getElementById("mailIcon");





let friendExpandedDown = false;
let friendExpandedActive = false;
let mailExpandedDown = false;
let mailExpandedActive = false;


// Send Friends Wrapper Down

friendIcons.forEach((icon)=>{
    icon.addEventListener("click", (evt)=>{
        // ON ICON CLICK
        if(!friendExpandedActive){
        const currentUserData = getUserData(evt.target.title);

        const removeFriendLink = document.createElement("a");
        
        removeFriendLink.className = "remove-friend-link";

        removeFriendLink.addEventListener("click", ()=>{
            if(confirm(`Are you sure you want to remove ${currentUserData[1] + " " + currentUserData[2]} from your friend list?`)){
                window.location.href =  `index.php?removefriend=${currentUserData[0]}`;
                console.log(`index.php?removefriend=${currentUserData[0]}`);
            }
        });

        friendExpandedName.textContent = currentUserData[1] + " " + currentUserData[2];
        friendExpandedDesc.textContent = "";
        friendExpandedLink.textContent = "Open Chat";
        const removeText = document.createElement("span");
        removeText.textContent = "Remove Friend";
        const removeImg = document.createElement("img");
            removeImg.src = "./img/red_exit.svg";
            removeFriendLink.append(removeImg);
            removeFriendLink.append(removeText);
            friendExpanded.appendChild(removeFriendLink);    
            friendExpandedWrapper.style.transform = "translateY(0)";
            friendExpandedActive = true;
        }
    });
});


// Send Nonfriends Wrapper Down
nonfriendIcons.forEach((icon)=>{
    icon.addEventListener("click", (evt)=>{
        // ON ICON CLICK
        if(!friendExpandedActive){
        const currentUserData = getUserData(evt.target.title);
        friendExpandedName.textContent = currentUserData[1] + " " + currentUserData[2];
        friendExpandedDesc.textContent = "";
        friendExpandedLink.textContent = "Add Friend";
        friendExpandedLink.href = `index.php?addfriend=${currentUserData[0]}`;
            friendExpandedWrapper.style.transform = "translateY(0)";
            friendExpandedActive = true;
        }
    });
});

// Send Mail Wrapper Down
mailIcon.addEventListener("click", ()=>{
    if(!mailExpandedActive){
        mailExpandedWrapper.style.transform = "translateY(0)";
            mailExpandedActive = true;
    }
});

// Send Wrappers Back Up

friendExpanded.addEventListener("mousedown",()=>{
    friendExpandedDown = true;
});

mailExpanded.addEventListener("mousedown",()=>{
    mailExpandedDown = true;
});

window.addEventListener("mouseup",()=>{
    friendExpandedDown = false;
    mailExpandedDown = false;
});

window.addEventListener("mousedown",()=>{
        if(!friendExpandedDown){
            friendExpandedWrapper.style.transform = "translateY(-100%)";
        }
        
        if((friendExpandedActive)){
        setTimeout(()=>{
            friendExpandedActive = false;
        },200);
    }
    
    if(!mailExpandedDown){
        mailExpandedWrapper.style.transform = "translateY(-100%)";
    }
        if((mailExpandedActive)){
        setTimeout(()=>{
            mailExpandedActive = false;
        },200);
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