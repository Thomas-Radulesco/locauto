
function init() {
    let inputImageFile = document.querySelector('#vehicle_pictureFile');
    let preview = document.querySelector('.vehicle-picture-preview');

    let fileTypes = [
        "image/png",
        "image/jpg",
        "image/jpeg",
        "image/webp"
    ]

    if(inputImageFile) {

        inputImageFile.style.height = 0;
        inputImageFile.style.padding = 0;
        inputImageFile.style.boxShadow = 0;

        if (inputImageFile == document.activeElement) {
            inputImageFile.style.boxShadow = 0;
        }
        inputImageFile.addEventListener('change', updateImagePreview);

        function updateImagePreview() {
            while(preview.firstChild) {
              preview.removeChild(preview.firstChild);
            }
            if (inputImageFile == document.activeElement) {
                inputImageFile.style.boxShadow = 'none';
            }
            let curFiles = inputImageFile.files;
            if(curFiles.length === 0) {
              let para = document.createElement('p');
              para.textContent = 'Aucune photo sélectionnée';
              preview.appendChild(para);
            } else {
              let list = document.createElement('ol');
              list.style.listStyleType = "none";
              preview.appendChild(list);
              let previousVehiclePicture = document.querySelector('.previous-vehicle-picture');
              if (previousVehiclePicture) {
                previousVehiclePicture.style.display = 'none';
              }
              for(let i = 0; i < curFiles.length; i++) {
                let listItem = document.createElement('li');
                let fileName = document.createElement('p');
                let fileSize = document.createElement('p');
                if(validFileType(curFiles[i])) {
                  fileName.textContent = 'Nom fichier : ' + curFiles[i].name + '.';
                  fileSize.textContent = 'Taille : ' + returnFileSize(curFiles[i].size) + '.';
                  let image = document.createElement('img');
                  image.src = window.URL.createObjectURL(curFiles[i]);
                  image.style.width = '180px'
          
                  listItem.appendChild(image);
                  listItem.appendChild(fileName);
                  listItem.appendChild(fileSize);
          
                } else {
                  fileName.textContent = 'Nom fichier ' + curFiles[i].name + ': n\'est pas un type de fichier valide, merci de réessayer.';
                  listItem.appendChild(fileName);
                }
          
                list.appendChild(listItem);
              }
            }
        }
          
        function validFileType(file) {
            for(let i = 0; i < fileTypes.length; i++) {
                if(file.type === fileTypes[i]) {
                    return true;
                }
            }
            return false;
        }

        function returnFileSize(number) {
            if(number < 1024) {
              return number + ' octets';
            } else if(number >= 1024 && number < 1048576) {
              return (number/1024).toFixed(1) + ' Ko';
            } else if(number >= 1048576) {
              return (number/1048576).toFixed(1) + ' Mo';
            }
          }
    }
}


window.addEventListener("DOMContentLoaded", () => {
    init();
  });