import React from "react";

class CreateFile extends React.Component {
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
                            <form
                                action="/teams/uploadFile"
                                className="dropzone"
                                method="POST"
                            >
                                <div className="dz-message">
                                    Arrastra aqui los archivos...
                                </div>
                                <div class="previews"></div>
                            </form>
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
}

export default CreateFile;
