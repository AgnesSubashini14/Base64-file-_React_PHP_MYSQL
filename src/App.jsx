import React, { useState } from "react";

function FileUpload() {
  const [selectedFile, setSelectedFile] = useState(null);
  const [base64File, setBase64File] = useState("");

  const handleFileChange = (e) => {
    const file = e.target.files[0];
    setSelectedFile(file);

    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => {
      setBase64File(reader.result);
    };
  };

  const handleSubmit = () => {
    fetch("http://localhost/php/base64/upload.php", {
      method: "POST",
      body: JSON.stringify({ base64File }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          console.log("File uploaded successfully.");
        } else {
          console.error("File upload failed.");
        }
      });
  };

  return (
    <div>
      <input type="file" onChange={handleFileChange} />
      <button onClick={handleSubmit}>Upload File</button>
    </div>
  );
}

export default FileUpload;
