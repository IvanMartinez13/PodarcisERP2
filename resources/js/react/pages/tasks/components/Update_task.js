import React from "react";

class Update_task extends React.Component {
    constructor(props) {
        super(props);

        this.state = { loading: true };

        this.project = this.props.project;
        this.task = this.props.task;

        this.selectedDepartaments = [];
        this.selectedUsers = [];
        this.description = this.task.description;
        this.name = this.task.name;

        this.options = [];

        this.departaments = [];
        this.users = [];
    }

    render() {
        if (this.state.loading) {
            return (
                <div
                    className="modal fade"
                    id={"updateTask" + this.task.token}
                    tabIndex="-1"
                    role="dialog"
                    aria-labelledby="modelTitleId"
                    aria-hidden="true"
                >
                    <div className="modal-dialog modal-xl" role="document">
                        <div className="modal-content bg-primary">
                            <div className="modal-header">
                                <h5 className="modal-title">
                                    Editar una tarea
                                </h5>
                                <button
                                    type="button"
                                    className="close"
                                    aria-label="Close"
                                    onClick={() => {
                                        $(
                                            "#updateTask" + this.task.token
                                        ).modal("hide");
                                    }}
                                >
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div className="modal-body bg-white text-dark text-center">
                                <div className="spiner-example">
                                    <div className="sk-spinner sk-spinner-double-bounce">
                                        <div className="sk-double-bounce1"></div>
                                        <div className="sk-double-bounce2"></div>
                                    </div>
                                </div>
                                Cargando...
                            </div>
                            <div className="modal-footer bg-white text-dark">
                                <button
                                    type="button"
                                    className="btn btn-primary"
                                >
                                    Editar
                                </button>
                                <button
                                    type="button"
                                    className="btn btn-secondary"
                                    onClick={() => {
                                        $(
                                            "#updateTask" + this.task.token
                                        ).modal("hide");
                                    }}
                                >
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            );
        }

        return (
            <div
                className="modal fade"
                id={"updateTask" + this.task.token}
                tabIndex="-1"
                role="dialog"
                aria-labelledby="modelTitleId"
                aria-hidden="true"
            >
                <div className="modal-dialog modal-xl" role="document">
                    <div className="modal-content bg-primary">
                        <div className="modal-header">
                            <h5 className="modal-title">Editar una tarea</h5>
                            <button
                                type="button"
                                className="close"
                                aria-label="Close"
                                onClick={() => {
                                    $("#updateTask" + this.task.token).modal(
                                        "hide"
                                    );
                                }}
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div className="modal-body bg-white text-dark text-left">
                            <div className="container-fluid row">
                                <div className="col-lg-6 mb-3">
                                    <label htmlFor={"name" + this.task.token}>
                                        Nombre:
                                    </label>
                                    <input
                                        defaultValue={this.task.name}
                                        className="form-control"
                                        name="name"
                                        id={"name" + this.task.token}
                                        placeholder="Nombre..."
                                    ></input>
                                </div>
                                <div className="col-lg-6 mb-3">
                                    <label
                                        htmlFor={
                                            "departaments" + this.task.token
                                        }
                                    >
                                        Departamentos:
                                    </label>
                                    <select
                                        defaultValue={this.selectedDepartaments}
                                        className="form-control"
                                        style={{ width: "100%" }}
                                        name="departaments"
                                        id={"departaments" + this.task.token}
                                        multiple="multiple"
                                    >
                                        {this.departaments.map(
                                            (departament, index) => {
                                                return (
                                                    <option
                                                        key={
                                                            departament.token +
                                                            index
                                                        }
                                                        value={
                                                            departament.token
                                                        }
                                                    >
                                                        {departament.name}
                                                    </option>
                                                );
                                            }
                                        )}
                                    </select>
                                </div>

                                <div className="col-lg-6 mb-3">
                                    <label htmlFor="users">Usuarios:</label>
                                    <select
                                        defaultValue={this.selectedUsers}
                                        className="form-control"
                                        style={{ width: "100%" }}
                                        name="users"
                                        id={"users" + this.task.token}
                                        multiple="multiple"
                                    >
                                        {this.users.map((user, index) => {
                                            return (
                                                <option
                                                    key={user.token + index}
                                                    value={user.token}
                                                >
                                                    {user.name}
                                                </option>
                                            );
                                        })}
                                    </select>
                                </div>

                                <div className="col-lg-6 mb-3">
                                    <label htmlFor="priority">Prioridad</label>
                                    <select
                                        defaultValue={this.task.priority_id}
                                        className="form-control"
                                        style={{ width: "100%" }}
                                        name="priority"
                                        id={"priority" + this.task.token}
                                    >
                                        <option value={1}>Alta</option>
                                        <option value={2}>Media</option>
                                        <option value={3}>Baja</option>
                                    </select>
                                </div>

                                <div className="col-lg-12 mb-3">
                                    <label
                                        htmlFor={
                                            "description" + this.task.token
                                        }
                                    >
                                        Descripción:
                                    </label>
                                    <textarea
                                        defaultValue={this.task.description}
                                        className="form-control"
                                        name="description"
                                        id={"description" + this.task.token}
                                        placeholder="Descripción..."
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                        <div className="modal-footer bg-white text-dark">
                            <button
                                type="button"
                                className="btn btn-primary"
                                onClick={() => {
                                    this.save();
                                }}
                            >
                                Editar
                            </button>
                            <button
                                type="button"
                                className="btn btn-secondary"
                                onClick={() => {
                                    $("#updateTask" + this.task.token).modal(
                                        "hide"
                                    );
                                }}
                            >
                                Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    componentDidMount() {
        axios
            .post("/tasks/project/get_departaments")
            .then((response) => {
                this.departaments = response.data.departaments;
                this.users = response.data.users;

                this.task.departaments.map((departament) => {
                    this.selectedDepartaments.push(departament.token);
                });

                if (this.task.users) {
                    this.task.users.map((user) => {
                        this.selectedUsers.push(user.token);
                    });
                }
              

                this.setState({ loading: false });
            })
            .then(() => {
                this.selectedDepartaments.map((token) => {
                    this.setUsers(token);
                });

                $("#users" + this.task.token).val(this.selectedUsers);
                $("#users" + this.task.token).trigger("change");

                $("#priority" + this.task.token).select2({
                    dropdownParent: $("#updateTask" + this.task.token), //FIXED COMMON PROBLEMS WHEN USES BOOTSTRAP MODAL
                    theme: "bootstrap4",
                    placeholder: "Selecciona un Prioridad...",
                    width: "100%", // need to override the changed default
                });

                $("#departaments" + this.task.token).select2({
                    dropdownParent: $("#updateTask" + this.task.token), //FIXED COMMON PROBLEMS WHEN USES BOOTSTRAP MODAL
                    theme: "bootstrap4",
                    placeholder: "Selecciona un departamento...",
                    width: "100%", // need to override the changed default
                    allowClear: true,
                });

                $("#users" + this.task.token).select2({
                    dropdownParent: $("#updateTask" + this.task.token), //FIXED COMMON PROBLEMS WHEN USES BOOTSTRAP MODAL
                    theme: "bootstrap4",
                    placeholder: "Selecciona un usuario...",
                    width: "100%", // need to override the changed default
                    allowClear: true,
                });

                const handlePrepareValue = (key, value) => {
                    this.prepareValue(key, value);
                };
                const handleSetUsers = (token) => {
                    this.setUsers(token);
                };

                $("#departaments" + this.task.token).on("change", (e) => {
                    let value = e.target.value;

                    if (!Array.isArray(value)) {
                        value = [value];
                    }

                    handlePrepareValue("departaments", value);
                    handleSetUsers(value);
                });

                const handleSelectUser = () => {
                    return this.selectedUsers;
                };

                $("#users" + this.task.token).on("select2:select", (e) => {
                    let value = e.params.data.id;
                    let array = handleSelectUser();
                    array.push(value);

                    handlePrepareValue("users", array);
                });

                $("#users" + this.task.token).on(
                    "select2:unselect",
                    function (e) {
                        var value = e.params.data.id;
                        let array = handleSelectUser();

                        array.map((user, index) => {
                            if (user == value) {
                                array.splice(index, 1); // 2nd parameter means remove one item only
                            }
                        });

                        handlePrepareValue("users", array);
                    }
                );

                $("#name" + this.task.token).on("input", (e) => {
                    let value = e.target.value;

                    handlePrepareValue("name", value);
                });

                $("#description" + this.task.token).summernote({
                    placeholder: "Descripción...",
                    height: "100px",
                });

                $("#description" + this.task.token).on(
                    "summernote.change",
                    function (e) {
                        // callback as jquery custom event
                        let value = e.target.value;

                        handlePrepareValue("description", value);
                    }
                );
            });
    }

    prepareValue(key, value) {
        if (key == "departaments") {
            this.selectedDepartaments = value;
        }

        if (key == "name") {
            this.name = value;
        }

        if (key == "description") {
            this.description = value;
        }

        if (key == "users") {
            this.selectedUsers = value;
        }
    }

    setUsers(token) {
        $("#users" + this.task.token)
            .text("")
            .trigger("change"); //CLEAR SELECT
        var departments = $("#departaments" + this.task.token).val();
        var users = [];
        this.users.map((user, index) => {
            user.departaments.map((departament) => {
                departments.map((department) => {
                    if (departament.token == department) {
                        if (!users.includes(user)) {
                            users.push(user);
                        }
                    }
                });
            });
        });

        users.map((user) => {
            let op = `<option value="${user.token}">${user.name}</option>`;
            $("#users" + this.task.token)
                .append(op)
                .trigger("change");
        });
    }

    save() {
        let data = {
            name: this.name,
            description: $("#description" + this.task.token).val(),
            departaments: this.selectedDepartaments,
            users: this.selectedUsers,
            project: this.project.id,
            priority: $("#priority" + this.task.token).val(),
            token: this.task.token,
        };

        //VALIDATE DATA
        let has_errors = false;

        if (data.name == "" || data.name == null) {
            has_errors = true;
            toastr.error("El campo Nombre es obligatorio");
        }

        if (data.description == "" || data.description == null) {
            has_errors = true;
            toastr.error("El campo Descripción es obligatorio");
        }

        if (
            data.departaments == "" ||
            data.departaments == null ||
            data.departaments == []
        ) {
            has_errors = true;
            toastr.error("El campo Departamentos es obligatorio");
        }

        if (!has_errors) {
            //SEND DATA
            axios.post("/tasks/project/update_task", data).then((response) => {
                if (response.data.status == "success") {
                    toastr.success(response.data.message);
                    //CLOSE MODAL
                    $("#addTask").modal("hide");

                    this.selectedDepartaments = [];
                    this.description = "";
                    this.name = "";

                    $("#departaments" + this.task.token).empty();
                    $("#name" + this.task.token).val(null);
                    $("#description" + this.task.token).val(null);
                    $("#description" + this.task.token).summernote("reset");

                    location.reload();
                }

                if (response.data.status == "error") {
                    toastr.error(response.data.message);
                }
            });
        }
    }
}

export default Update_task;
