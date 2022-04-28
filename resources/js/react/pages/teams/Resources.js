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
            update: false,
        };

        this.updateMe = this.updateMe.bind(this);
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
                        onClick={() => {
                            $("#createFile").modal("show");
                        }}
                    >
                        Añadir archivos{" "}
                        <i className="fa fa-file" aria-hidden="true"></i>
                    </button>
                </div>

                <div className="row m-lg-3 p-lg-2">
                    <div className="col-8">
                        <h3 className="">{this.formatPath()}</h3>
                    </div>

                    {this.state.actualPath != this.root ? (
                        <div className="col-4 text-right">
                            <button
                                onClick={() => {
                                    this.changePath(this.root);
                                }}
                                className="btn btn-secondary mx-1"
                            >
                                Recursos
                            </button>

                            <button
                                onClick={() => {
                                    //RETURN 1 STEP
                                    let array =
                                        this.state.actualPath.split("/");

                                    let path = this.state.actualPath.replace(
                                        "/" + array[array.length - 1],
                                        ``
                                    );

                                    this.changePath(path);
                                }}
                                className="btn btn-danger mx-1"
                            >
                                Volver
                            </button>
                        </div>
                    ) : (
                        <div className="col-4 text-right"></div>
                    )}
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
                                            style={{ color: "black" }}
                                            role={"button"}
                                            onClick={() => {
                                                this.changePath(file.path);
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
                                            style={{ color: "black" }}
                                            role={"button"}
                                            href={
                                                "/storage/teams/" +
                                                this.team.customer_id +
                                                "/" +
                                                file.path
                                            }
                                            target={"_blank"}
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
                                            style={{ color: "black" }}
                                            role={"button"}
                                            href={
                                                "/storage/teams/" +
                                                this.team.customer_id +
                                                "/" +
                                                file.path
                                            }
                                            target={"_blank"}
                                        >
                                            <div className="card h-100">
                                                <div
                                                    className="card-body h-75 text-center"
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
                    updateMe={this.updateMe}
                ></CreateFolder>

                <CreateFile
                    path={this.state.actualPath}
                    team={this.team}
                    updateMe={this.updateMe}
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

                if (content != false) {
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
                                    check[check.length - 1] == "png" ||
                                    check[check.length - 1] == "jpg" ||
                                    check[check.length - 1] == "jpeg" ||
                                    check[check.length - 1] == "svg" ||
                                    check[check.length - 1] == "gif"
                                ) {
                                    files.push({
                                        type: "image",
                                        path:
                                            this.state.actualPath + "/" + file,
                                        name: file,
                                    });
                                } else {
                                    //PDF
                                    if (check[check.length - 1] == "pdf") {
                                        files.push({
                                            type: "pdf",
                                            path:
                                                this.state.actualPath +
                                                "/" +
                                                file,
                                            name: file,
                                        });
                                    } else {
                                        //TEXT
                                        files.push({
                                            type: "other",
                                            path:
                                                this.state.actualPath +
                                                "/" +
                                                file,
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
                } else {
                    this.setState({
                        loading: false,
                        files: [],
                    });
                }
            });
    }

    componentDidUpdate(prevProps, prevState) {
        if (
            this.state.actualPath != prevState.actualPath ||
            this.state.update == true
        ) {
            axios
                .post("/teams/get/files", {
                    path: this.state.actualPath,
                    team: this.team.token,
                })
                .then((response) => {
                    var files = [];
                    var content = response.data.files;

                    if (content != false) {
                        content.map((file, index) => {
                            if (index > 1) {
                                var check = file.split(".");

                                if (check.length == 1) {
                                    files.push({
                                        type: "folder",
                                        path:
                                            this.state.actualPath + "/" + file,
                                        name: file,
                                    });
                                } else {
                                    //IMG
                                    console.log(check[check.length - 1]);
                                    if (
                                        check[check.length - 1] == "png" ||
                                        check[check.length - 1] == "jpg" ||
                                        check[check.length - 1] == "jpeg" ||
                                        check[check.length - 1] == "svg" ||
                                        check[check.length - 1] == "gif"
                                    ) {
                                        files.push({
                                            type: "image",
                                            path:
                                                this.state.actualPath +
                                                "/" +
                                                file,
                                            name: file,
                                        });
                                    } else {
                                        //PDF
                                        if (check[check.length - 1] == "pdf") {
                                            files.push({
                                                type: "pdf",
                                                path:
                                                    this.state.actualPath +
                                                    "/" +
                                                    file,
                                                name: file,
                                            });
                                        } else {
                                            //TEXT
                                            files.push({
                                                type: "other",
                                                path:
                                                    this.state.actualPath +
                                                    "/" +
                                                    file,
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
                            update: false,
                        });
                    } else {
                        this.setState({
                            loading: false,
                            files: [],
                            update: false,
                        });
                    }
                });
        }
    }

    changePath(newPath) {
        this.setState({
            loading: true,
            actualPath: newPath,
        });
    }

    formatPath() {
        let path = this.state.actualPath;
        let root = this.root;

        path = path.replace(this.root, `Recursos`);

        return path;
    }

    updateMe() {
        this.setState({
            loading: true,
            actualPath: this.state.actualPath,
            update: true,
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
