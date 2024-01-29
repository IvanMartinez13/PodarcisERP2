import axios from "axios";
import React from "react";

class Create_subtask extends React.Component {
    constructor(props) {
        super(props);

        this.name = "";
        this.description = "";
        this.year = "";
        this.task = this.props.task;
        this.users = this.props.users;
        this.selectedUsers = [];

        this.setLoading = (data) => {
            this.props.setLoading(data);
        };

        this.setSaving = (data) => {
            this.props.setSaving(data);
        };
    }

    render() {
        return (
            <div
                className="modal fade"
                id="modalSubtask"
                tabIndex="-1"
                role="dialog"
                aria-labelledby="modalSubtaskLabel"
                aria-hidden="true"
            >
                <div className="modal-dialog modal-xl" role="document">
                    <div className="modal-content bg-primary">
                        <div className="modal-header">
                            <h5 className="modal-title" id="modalSubtaskLabel">
                                Añadir subtarea
                            </h5>
                            <button
                                type="button"
                                className="close"
                                aria-label="Close"
                                onClick={() => {
                                    $("#modalSubtask").modal("hide");
                                }}
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div className="modal-body bg-white text-dark">
                            <div className="row">
                                <div className="col-lg-12 my-3">
                                    <label htmlFor="name">Nombre:</label>
                                    <input
                                        id="name"
                                        className="form-control"
                                        name="name"
                                        placeholder="Nombre..."
                                    ></input>
                                </div>

                                <div className="col-lg-12 my-3">
                                    <label htmlFor="year">Año:</label>
                                    <input
                                        id="year"
                                        type="number"
                                        className="form-control"
                                        name="year"
                                        placeholder="Año..."
                                    ></input>
                                </div>

                                <div className="col-lg-12 my-3">
                                    <label htmlFor="users">Usuarios:</label>
                                    <select
                                        id="users"
                                        name="users"
                                        className="form-control"
                                        multiple
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

                                <div className="col-lg-12 my-3">
                                    <label htmlFor="description">
                                        Descripción:
                                    </label>
                                    <textarea
                                        id="description"
                                        className="form-control"
                                        name="description"
                                        placeholder="Descripción..."
                                        rows={5}
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
                                Crear
                            </button>
                            <button
                                type="button"
                                className="btn btn-secondary"
                                onClick={() => {
                                    $("#modalSubtask").modal("hide");
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
        const handlePrepareValue = (key, value) => {
            this.prepareData(key, value);
        };

        $("#name").on("input", function (e) {
            let value = e.target.value;

            handlePrepareValue("name", value);
        });

        $("#year").on("input", function (e) {
            let value = e.target.value;

            handlePrepareValue("year", value);
        });

        $("#users").select2({
            dropdownParent: $("#modalSubtask"), //FIXED COMMON PROBLEMS WHEN USES BOOTSTRAP MODAL
            theme: "bootstrap4",
            placeholder: "Selecciona un usuario...",
            width: "100%", // need to override the changed default
            allowClear: true,
        });
        const handleSelectUser = () => {
            return this.selectedUsers;
        };

        $("#users").on("select2:select", (e) => {
            let value = e.params.data.id;
            let array = handleSelectUser();
            array.push(value);

            handlePrepareValue("users", array);
        });

        $("#users").on("select2:unselect", (e) => {
            var value = e.params.data.id;
            let array = handleSelectUser();

            array.map((user, index) => {
                if (user == value) {
                    array.splice(index, 1); // 2nd parameter means remove one item only
                }
            });

            handlePrepareValue("users", array);
        });
    }

    prepareData(key, value) {
        if (key == "name") {
            this.name = value;
        }

        if (key == "users") {
            this.selectedUsers = value;
        }

        if (key == "year") {
            this.year = value;
        }
    }

    save() {
        let data = {
            name: this.name,
            year: Number(this.year),
            description: $("#description").val(),
            task: this.task,
            users: this.selectedUsers,
        };

        console.log(data);
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

        if (!has_errors) {
            axios
                .post("/tasks/project/task/add_subtask", data)
                .then((response) => {
                    if (response.data.status == "success") {
                        toastr.success(response.data.message);

                        //CLOSE MODAL
                        $("#modalSubtask").modal("hide");

                        this.description = "";
                        this.name = "";
                        this.selectedUsers = [];

                        $("#name").val(null);
                        $("#description").val(null);
                        $("#description").summernote("reset");
                        $("#users").val(null);

                        $("#progress").css({
                            width: response.data.progress + "%",
                        });
                        $("#progress_text").text(response.data.progress + "%");

                        //UPLOAD PARENT
                        this.setLoading(true);
                        this.setSaving(true);
                    }

                    if (response.data.status == "error") {
                        toastr.error(response.data.message);
                    }
                });
        }
    }
}

export default Create_subtask;
