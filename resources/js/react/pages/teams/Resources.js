import React from "react";
import ReactDOM from "react-dom";
import CreateFolder from "./CreateFolder";
import CreateFile from "./CreateFile";

class Resources extends React.Component {
    //constructor

    constructor(props) {
        super(props);

        this.user = this.props.user;
        this.team = this.props.team;
        this.root = this.team.token + "/resources";

        this.state = {
            loading: true,
            actualPath: this.root,
            files: [],
        };
    }

    render() {
        //LOADING
        if (this.state.loading) {
            return (
                <div className="animated fadeIn">
                    <div className="spiner-example">
                        <div className="sk-spinner sk-spinner-double-bounce">
                            <div className="sk-double-bounce1"></div>
                            <div className="sk-double-bounce2"></div>
                        </div>
                    </div>

                    <p className="text-center">Cargando...</p>
                </div>
            );
        }

        return (
            <div>
                <div className="btn-group m-lg-3">
                    <button
                        className="btn btn-white mx-1 rounded"
                        data-toggle="modal"
                        data-target="#createFolder"
                    >
                        Crear directorio{" "}
                        <i className="fa fa-folder" aria-hidden="true"></i>
                    </button>

                    <button
                        className="btn btn-white mx-1 rounded"
                        data-toggle="modal"
                        data-target="#createFile"
                    >
                        Añadir archivos{" "}
                        <i className="fa fa-file" aria-hidden="true"></i>
                    </button>
                </div>

                <div className="bg-light m-lg-3 p-lg-2 rounded">
                    <div className="row p-3">
                        {this.state.files.map((file, index) => {
                            //FOLDER
                            if (file.type == "folder") {
                                return (
                                    <div
                                        key={file.name + index}
                                        className="col-lg-3 col-md-4 mb-3"
                                    >
                                        <a
                                            role={"button"}
                                            onClick={() => {
                                                console.log(
                                                    "/storage/teams/" +
                                                        this.team.customer_id +
                                                        "/" +
                                                        file.path
                                                );
                                            }}
                                        >
                                            <div className="card h-100">
                                                <div className="card-body d-flex h-75">
                                                    <i
                                                        className="fa fa-folder fa-6x m-auto"
                                                        aria-hidden="true"
                                                    ></i>
                                                </div>

                                                <div className="card-footer d-flex h-25">
                                                    <p className="my-auto">
                                                        {file.name}
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                );
                            }

                            //FILES
                            if (file.type == "pdf") {
                                return (
                                    <div
                                        key={file.name + index}
                                        className="col-lg-3 col-md-4 mb-3"
                                    >
                                        <a
                                            role={"button"}
                                            onClick={() => {
                                                console.log(
                                                    "/storage/teams/" +
                                                        this.team.customer_id +
                                                        "/" +
                                                        file.path
                                                );
                                            }}
                                        >
                                            <div className="card h-100">
                                                <div className="card-body d-flex h-75">
                                                    <i class="fas fa-file-pdf  fa-6x m-auto"></i>
                                                </div>

                                                <div className="card-footer d-flex h-25">
                                                    <p className="my-auto">
                                                        {file.name}
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                );
                            }

                            if (file.type == "image") {
                                return (
                                    <div
                                        key={file.name + index}
                                        className="col-lg-3 col-md-4 mb-3"
                                    >
                                        <a
                                            role={"button"}
                                            onClick={() => {
                                                console.log(file.path);
                                            }}
                                        >
                                            <div className="card h-100">
                                                <div
                                                    className="card-body h-75"
                                                    style={{
                                                        overflow: "hidden",
                                                    }}
                                                >
                                                    <img
                                                        src={
                                                            "/storage/teams/" +
                                                            this.team
                                                                .customer_id +
                                                            "/" +
                                                            file.path
                                                        }
                                                        className="img-fluid h-100"
                                                    ></img>
                                                </div>

                                                <div className="card-footer d-flex h-25">
                                                    <p className="my-auto">
                                                        {file.name}
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                );
                            }
                        })}
                    </div>
                </div>

                <CreateFolder
                    path={this.state.actualPath}
                    team={this.team}
                ></CreateFolder>

                <CreateFile
                    path={this.state.actualPath}
                    team={this.team}
                ></CreateFile>
            </div>
        );
    }

    componentDidMount() {
        axios
            .post("/teams/get/files", {
                path: this.state.actualPath,
                team: this.team.token,
            })
            .then((response) => {
                var files = [];
                var content = response.data.files;

                content.map((file, index) => {
                    if (index > 1) {
                        var check = file.split(".");

                        if (check.length == 1) {
                            files.push({
                                type: "folder",
                                path: this.state.actualPath + "/" + file,
                                name: file,
                            });
                        } else {
                            //IMG
                            if (
                                check[1] == "png" ||
                                check[1] == "jpg" ||
                                check[1] == "svg" ||
                                check[1] == "gif"
                            ) {
                                files.push({
                                    type: "image",
                                    path: this.state.actualPath + "/" + file,
                                    name: file,
                                });
                            } else {
                                //PDF
                                if (check[1] == "pdf") {
                                    files.push({
                                        type: "pdf",
                                        path:
                                            this.state.actualPath + "/" + file,
                                        name: file,
                                    });
                                } else {
                                    //TEXT
                                    files.push({
                                        type: "other",
                                        path:
                                            this.state.actualPath + "/" + file,
                                        name: file,
                                    });
                                }
                            }
                        }
                    }
                });

                this.setState({
                    loading: false,
                    files: files,
                });
            });
    }
}

export default Resources;

if (document.getElementsByTagName("resources").length >= 1) {
    let component = document.getElementsByTagName("resources")[0];
    let user = JSON.parse(component.getAttribute("user"));
    let team = JSON.parse(component.getAttribute("team"));

    ReactDOM.render(<Resources user={user} team={team} />, component);
}
