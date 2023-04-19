import axios from "axios";
import React from "react";
import ReactDOM from "react-dom";
import Create_subtask from "./components/Create_subtask";
import Edit_subtask from "./components/Edit_subtask";

class Subtasks extends React.Component {
    constructor(props) {
        super(props);

        this.state = { loading: true, save: false, year: 0 };

        this.task = this.props.task;
        this.project = this.props.project;
        this.subtasks = [];
        this.users = [];
        this.years = [];

        this.setLoading = this.setLoading.bind(this);
        this.setSaving = this.setSaving.bind(this);

        this.store = this.props.store;
        this.update = this.props.update;
        this.delete = this.props.delete;
    }

    render() {
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

        if (this.state.year == 0) {
            return (
                <div className="animated fadeIn">
                    <select id="subtask_year">
                        {this.years.map((year) => {
                            return (
                                <option
                                    key={year + "option_especial"}
                                    value={year}
                                >
                                    {" "}
                                    {year}{" "}
                                </option>
                            );
                        })}
                    </select>
                </div>
            );
        }

        return (
            <div className="animated fadeIn">
                <select id="subtask_year">
                    {this.years.map((year) => {
                        return (
                            <option key={year + "option_especial"} value={year}>
                                {" "}
                                {year}{" "}
                            </option>
                        );
                    })}
                </select>

                {this.store == 1 ? (
                    <button
                        className="btn btn-link"
                        onClick={() => {
                            $("#modalSubtask").modal("show");
                            $("#description").summernote({
                                placeholder: "Descripción...",
                                height: 200,
                            });
                        }}
                    >
                        <i className="fa fa-plus-circle" aria-hidden="true"></i>{" "}
                        Añadir subtarea
                    </button>
                ) : null}

                <div className="table-responsive">
                    <table className="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Tarea</th>
                                <th>Descripción</th>
                                <th>Progreso</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            {this.subtasks.map((subtask, index) => {
                                return (
                                    <tr key={"row_" + subtask.token + index}>
                                        <td className="align-middle text-center">
                                            {this.update == 1 ? (
                                                subtask.is_done == 1 ? (
                                                    <input
                                                        className="i-checks"
                                                        type={"checkbox"}
                                                        defaultChecked={true}
                                                        defaultValue={
                                                            subtask.token
                                                        }
                                                    ></input>
                                                ) : (
                                                    <input
                                                        className="i-checks"
                                                        type={"checkbox"}
                                                        defaultChecked={false}
                                                        defaultValue={
                                                            subtask.token
                                                        }
                                                    ></input>
                                                )
                                            ) : null}
                                        </td>
                                        <td className="align-middle">
                                            {subtask.name}
                                        </td>
                                        <td
                                            className="align-middle"
                                            dangerouslySetInnerHTML={{
                                                __html: subtask.description,
                                            }}
                                        ></td>
                                        <td>
                                            <div className="progress m-b-1">
                                                <div
                                                    style={{
                                                        width:
                                                            subtask.progress +
                                                            "%",
                                                    }}
                                                    className="progress-bar progress-bar-striped progress-bar-animated"
                                                ></div>

                                            </div>

                                            <small>
                                                Completado en un{" "}
                                                <strong>
                                                    {subtask.progress}%
                                                </strong>
                                                .
                                            </small>
                                        </td>


                                        <td className="align-middle text-center">
                                            <div className="btn-group">
                                                {this.update == 1 ? (
                                                    <button
                                                        className="btn btn-link"
                                                        onClick={() => {
                                                            $(
                                                                "#editModalSubtask" +
                                                                    subtask.token
                                                            ).modal("show");
                                                            $(
                                                                "#description" +
                                                                    subtask.token
                                                            ).summernote({
                                                                placeholder:
                                                                    "Descripción...",
                                                                height: 200,
                                                            });
                                                        }}
                                                    >
                                                        <i
                                                            className="fa fa-pencil"
                                                            aria-hidden="true"
                                                        ></i>
                                                    </button>
                                                ) : null}

                                                <a
                                                    href={
                                                        "/tasks/project/" +
                                                        this.project +
                                                        "/task/" +
                                                        subtask.token
                                                    }
                                                    className="btn btn-link"
                                                >
                                                    <i
                                                        className="fa-solid fa-clipboard-check"
                                                        aria-hidden="true"
                                                    ></i>
                                                </a>

                                                {this.delete == 1 ? (
                                                    <button
                                                        className="btn btn-link"
                                                        onClick={() => {
                                                            this.remove(
                                                                subtask.token
                                                            );
                                                        }}
                                                    >
                                                        <i
                                                            className="fa fa-trash-alt"
                                                            aria-hidden="true"
                                                        ></i>
                                                    </button>
                                                ) : null}
                                            </div>
                                        </td>
                                    </tr>
                                );
                            })}
                        </tbody>
                    </table>
                </div>

                <Create_subtask
                    task={this.task}
                    users={this.users}
                    setLoading={this.setLoading}
                    setSaving={this.setSaving}
                ></Create_subtask>

                {this.subtasks.map((subtask, index) => {
                    return (
                        <Edit_subtask
                            key={"updateSubtask_" + subtask.token}
                            task={this.task}
                            setLoading={this.setLoading}
                            setSaving={this.setSaving}
                            id={subtask.token}
                            subtask={subtask}
                            users={this.users}
                        ></Edit_subtask>
                    );
                })}
            </div>
        );
    }

    componentDidMount() {
        axios
            .post("/tasks/project/task/get_subtask", {
                task: this.task,
                year: this.state.year,
            })
            .then((response) => {
                let subtasks = response.data.subtasks;
                let users = response.data.users;
                this.subtasks = subtasks;
                this.users = users;

                for (let index = 2021; index < 2031; index++) {
                    this.years.push(index);
                }

                this.setState({ loading: false });
            })
            .then(() => {
                if (this.state.year != 0) {
                    $("#subtask_year").val(this.state.year);
                } else {
                    $("#subtask_year").val(null);
                }

                $("#subtask_year").select2({
                    theme: "bootstrap4",
                    width: "100px",
                    placeholder: "Selecciona un año",
                });

                const handleSetYear = (data) => {
                    this.setState({ loading: true, year: data, save: true });
                };

                $("#subtask_year").on("change", function (e) {
                    //RECARGAR EL COMPONENTE
                    handleSetYear($("#subtask_year").val());
                });

                $(".i-checks").iCheck({
                    checkboxClass: "icheckbox_square-green",
                    radioClass: "iradio_square-green",
                });

                const handleFinishTask = (data) => {
                    this.finishTask(data);
                };

                $(".i-checks").on("ifChecked", function (event) {
                    let task = event.target.value;

                    let data = {
                        task: task,
                        value: true,
                    };

                    handleFinishTask(data);
                });
                $(".i-checks").on("ifUnchecked", function (event) {
                    let task = event.target.value;

                    let data = {
                        task: task,
                        value: false,
                    };

                    handleFinishTask(data);
                });
            });
    }

    componentDidUpdate() {
        if (this.state.save) {
            let year = this.state.year;
            console.log(year);

            axios
                .post("/tasks/project/task/get_subtask", {
                    task: this.task,
                    year: year,
                })
                .then((response) => {
                    let subtasks = response.data.subtasks;
                    this.subtasks = subtasks;

                    this.setState({ loading: false, save: false });
                })
                .then(() => {
                    if (this.state.year != 0) {
                        $("#subtask_year").val(this.state.year);
                    } else {
                        $("#subtask_year").val(null);
                    }

                    $("#subtask_year").select2({
                        theme: "bootstrap4",
                        width: "100px",
                        placeholder: "Selecciona un año",
                    });
                    const handleSetYear = (data) => {
                        this.setState({
                            loading: true,
                            year: data,
                            save: true,
                        });
                    };

                    $("#subtask_year").on("change", function (e) {
                        //RECARGAR EL COMPONENTE
                        handleSetYear($("#subtask_year").val());
                    });
                    $(".i-checks").iCheck({
                        checkboxClass: "icheckbox_square-green",
                        radioClass: "iradio_square-green",
                    });

                    const handleFinishTask = (data) => {
                        this.finishTask(data);
                    };

                    $(".i-checks").on("ifChecked", function (event) {
                        let task = event.target.value;

                        let data = {
                            task: task,
                            value: true,
                        };

                        handleFinishTask(data);
                    });
                    $(".i-checks").on("ifUnchecked", function (event) {
                        let task = event.target.value;

                        let data = {
                            task: task,
                            value: false,
                        };

                        handleFinishTask(data);
                    });
                });
        }
    }

    setLoading(value) {
        this.setState({ loading: value });
    }

    setSaving(value) {
        this.setState({ save: value });
    }

    finishTask(data) {
        axios
            .post("/tasks/project/task/subtask/changeState", data)
            .then((response) => {
                toastr.success(response.data.message);

                $("#progress").css({ width: response.data.progress + "%" });
                $("#progress_text").text(response.data.progress + "%");
            });
    }

    remove(token) {
        swal(
            {
                title: "¿Estás seguro?",
                text: "No podrás recuperar esta subtarea.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ed5565",
                confirmButtonText: "Si, deseo eliminarla",
                closeOnConfirm: false,
                cancelButtonColor: "#ed5565",
                cancelButtonText: "Cancelar",
            },
            function () {
                axios
                    .post("/tasks/projects/delete_subtask", { token: token })
                    .then((response) => {
                        toastr.success(response.data.message);
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    });
            }
        );
    }
}

export default Subtasks;

if (document.getElementsByTagName("subtasks").length >= 1) {
    let component = document.getElementsByTagName("subtasks")[0];
    let task = JSON.parse(component.getAttribute("task"));
    let project = JSON.parse(component.getAttribute("project"));

    let store = component.getAttribute("store");
    let update = component.getAttribute("update");
    let del = component.getAttribute("delete");

    ReactDOM.render(
        <Subtasks
            task={task}
            project={project}
            store={store}
            update={update}
            delete={del}
        />,
        component
    );
}
