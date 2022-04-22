import axios from "axios";
import React from "react";

class CreateFolder extends React.Component {
    //constructor
    constructor(props) {
        super(props);
        this.path = this.props.path;
        this.team = this.props.team;
    }

    render() {
        return (
            <div
                className="modal fade"
                id="createFolder"
                tabIndex={-1}
                aria-labelledby="createFolderLabel"
                aria-hidden="true"
            >
                <div className="modal-dialog">
                    <div className="modal-content bg-primary">
                        <div className="modal-header">
                            <h5 className="modal-title" id="createFolderLabel">
                                Crear un nuevo directorio
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
                            <label htmlFor="dirName">Nombre:</label>
                            <input
                                className="form-control"
                                placeholder="Nombre..."
                                id="dirName"
                            ></input>
                        </div>
                        <div className="modal-footer bg-white text-dark">
                            <button
                                type="button"
                                className="btn btn-primary"
                                onClick={() => {
                                    this.save();
                                }}
                            >
                                Crear
                            </button>

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

    save() {
        let name = $("#dirName").val();

        if (name != null && name != "" && name != undefined) {
            //save
            axios
                .post("/teams/create/folder", {
                    path: this.path,
                    team: this.team.token,
                    name: name,
                })
                .then((response) => {
                    if (response.data.status == "error") {
                        toastr.error(response.data.message);
                        return null;
                    }
                    toastr.success(response.data.message);
                });
        } else {
            toastr.error("El campo Nombre es obligatorio.");
        }
    }
}

export default CreateFolder;
