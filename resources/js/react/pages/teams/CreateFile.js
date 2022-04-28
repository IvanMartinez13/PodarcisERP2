import { Toast } from "bootstrap";
import Dropzone from "dropzone";
import React from "react";

class CreateFile extends React.Component {
    constructor(props) {
        super(props);
        this.path = this.props.path;
        this.team = this.props.team;

        this.updateMe = () => {
            this.props.updateMe();
        };
    }

    render() {
        return (
            <div
                className="modal fade"
                id="createFile"
                tabIndex={-1}
                aria-labelledby="createFileLabel"
                aria-hidden="true"
            >
                <div className="modal-dialog modal-xl">
                    <div className="modal-content bg-primary">
                        <div className="modal-header">
                            <h5 className="modal-title" id="createFileLabel">
                                Crear un nuevo archivo
                            </h5>
                            <button
                                type="button"
                                className="close"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div className="modal-body bg-white text-dark">
                            <div
                                id="uploadFiles"
                                className="dropzone"
                                method="POST"
                            >
                                <div className="dz-message">
                                    Arrastra aqui los archivos...
                                </div>
                                <div className="previews"></div>
                            </div>
                        </div>
                        <div className="modal-footer bg-white text-dark">
                            <button
                                type="button"
                                className="btn btn-secondary"
                                data-dismiss="modal"
                            >
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    componentDidMount() {
        var path = this.path;
        var team = this.team.token;

        const handleFinish = () => {
            this.finish();
        };

        let dropzone = new Dropzone("div#uploadFiles", {
            url: "/teams/upload/file",

            headers: {
                "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },

            uploadMultiple: true,
            autoProcessQueue: true,
            parallelUploads: 100,
            maxFiles: 100,

            init: function () {
                var myDropzone = this;

                // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
                // of the sending event because uploadMultiple is set to true.
                this.on("sendingmultiple", function (file, xsr, formData) {
                    // Gets triggered when the form is actually being sent.
                    // Hide the success button or the complete form.
                    formData.append("path", path);
                    formData.append("team", team);

                    console.log("sended");
                });

                this.on("successmultiple", function (files, response) {
                    // Gets triggered when the files have successfully been sent.
                    // Redirect user or notify of success.
                    this.removeAllFiles();

                    //MOSTAR ALERTA

                    if (response.status == "success") {
                        //ok
                        toastr.success(
                            response.message +
                                " con " +
                                response.with_errors +
                                " errores."
                        );

                        //close modal

                        handleFinish();
                    } else {
                        //error
                        toastr.error(response.message);
                    }

                    //ACTUALIZAR
                });

                this.on("errormultiple", function (files, response) {
                    // Gets triggered when there was an error sending the files.
                    // Maybe show form again, and notify user of error
                    console.log("error");

                    //MOSTAR ALERTA
                    toastr.error(response.message);
                });
            },
        });
    }

    finish() {
        $("#createFile").modal("hide");
        this.updateMe();
    }
}

export default CreateFile;
