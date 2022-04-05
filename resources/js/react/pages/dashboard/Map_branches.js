import React from "react";
import ReactDOM  from "react-dom";
import axios from "axios";

class Map_branches extends React.Component{

    constructor(props)
    {
        super(props)

        this.branches = this.props.branches;

        this.state = {loading: true}
    }

    render()
    {
        if (this.state.loading) {
            return(
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

        return(
            <div id="branch_map" style={{height: '100%', borderRadius: "16px"}}></div>
        )
    }

    componentDidMount()
    {
        let coordinates = [];
        let names = [];
        let promise = new Promise(( resolve ) => {
            
            this.branches.map( (branch) => {
                coordinates.push(branch.coordinates);
                names.push(branch.name);
            })

            this.setState({loading: false})

            setTimeout(() => {
                resolve(coordinates);
            }, 250 )
            
            
        });

        promise.then((coordinates) => {
            
            const map = new L.Map('branch_map', {
                preferCanvas: true,
                attributionControl: false
            });

            map.setView(new L.LatLng(37.91603433975963, -1.1206054687500002), 6);

            var localLang = 'es';

            const satelital = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                minZoom: 5,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            });
        
            const hybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            });
        
            const streets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            });
        
            const terrain = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            });
        
        
        
            map.addLayer(hybrid);
        
            var baseMaps = {
        
                "Satelite": satelital,
                "Ciudades": streets,
                "Ciudades Satelite": hybrid,
                "Terreno": terrain
        
            };
        
            var control = L.control.layers(baseMaps, null, {
                collapsed: true,
            }).addTo(map);

            map.addControl(new L.Control.Fullscreen());

            coordinates.map( (coord, idx) => {
                this.addPin(coord, map, names[idx])
            } )
        });
    }


    addPin(coordinates, map, name){
    
        coordinates = coordinates.split(',')

        var icon = L.icon({
            iconUrl: '/img/markers/building.svg',
            //shadowUrl: 'leaf-shadow.png',
            iconSize:     [30, 30], // size of the icon
            shadowSize:   [30, 30], // size of the shadow
            iconAnchor:   [22, 22], // point of the icon which will correspond to marker's location
            shadowAnchor: [4, 62],  // the same for the shadow
            popupAnchor:  [0, -20] // point from which the popup should open relative to the iconAnchor
        });

        var newMarker = new L.marker(coordinates, { icon: icon });
        newMarker.bindPopup(`<div class="p-2">${name}</div>`)

        newMarker.addTo(map)
    
            //var coordinates = e.latlng.lat + ", " + e.latlng.lng;
    
    }
}

export default Map_branches;


if (document.getElementsByTagName('map-branches').length >=1) {
    
    let component = document.getElementsByTagName('map-branches')[0];
    let branches = JSON.parse(component.getAttribute('branches'));
    

    ReactDOM.render(<Map_branches branches={branches} />, component);
}