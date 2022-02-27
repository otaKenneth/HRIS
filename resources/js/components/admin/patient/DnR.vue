<template>
    <div class="container-fluid">
		<image-viewer :imageD="imageDialog" :img="selected_image"></image-viewer>
        <form class="form-group col-md-12 m-0">
            <div class="form-group d-flex">
				<label for="request" class="font-semibold mr-2">Request</label>
				<input type="file" class="form-control-file" name="request" id="request" accept="image/*" placeholder="" @change="readUrlRequest" multiple>
				<button type="button" class="btn btn-primary mx-2" @click="createRequest">Save</button>
				<button type="button" class="btn btn-danger mx-2" @click="deleteRequest">Delete</button>
            </div>
            <div class="preview border border-solid p-1 row" style="min-height: 30px;">
				<div v-for="(req,k) in req_arr" :key="k" class="w-20 h-20 m-1 cursor-pointer">
					<input type="checkbox" name="requests" :id="'req'+req.id" style="position: absolute; margin: 4px" v-model="requests" :value="req.id">
					<img :src="'/storage/' + req.request" :id="'reg'+k" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;" alt="" @click="showImage">
				</div>
			</div>
        </form>
        <div class="form-group col-md-12 m-0">
            <div class="form-group d-flex">
				<label for="diagnosis" class="font-semibold mr-2">Diagnosis</label>
				<input type="file" class="form-control-file" name="diagnosis" id="diagnosis" accept="image/*" placeholder="" @change="readUrlDiagnosis" multiple>
				<button type="button" class="btn btn-primary mx-2" @click="createDiagnoses">Save</button>
				<button type="button" class="btn btn-danger mx-2" @click="deleteDiagnoses">Delete</button>
            </div>
            <div class="preview border border-sold p-1 row" style="min-height: 30px;">
				<div v-for="(diag,k) in diags_arr" :key="k" class="w-20 h-20 m-1 cursor-pointer">
					<input type="checkbox" name="requests" :id="'diag'+diag.id" style="position: absolute; margin: 4px" v-model="diagnoses" :value="diag.id">
					<img :src="'/storage/' + diag.diagnosis" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;" alt="" @click="showImage">
				</div>
			</div>
        </div>
    </div>
</template>
<script>
export default {
	props: ['reqs','rid','diags'],
	data () {
		return {
			requests: [],
			diagnoses: [],
			errors: [],
			diags_arr: this.diags,
			req_arr: this.reqs,
			selected_image: '',
			imageDialog: false,
		}
	},
	methods: {
		readUrlRequest (ev) {
			if (ev.target.files) {
				var reader = new FileReader();
				for (let index = 0; index < ev.target.files.length; index++) {
					this.requests[index] = ev.target.files[index];
					
					// reader.readAsDataURL(ev.target.files[index]);
				}

			}
		},
		readUrlDiagnosis (ev) {
			if (ev.target.files) {
				var reader = new FileReader();
				for (let index = 0; index < ev.target.files.length; index++) {
					this.diagnoses[index] = ev.target.files[index];
					
					// reader.readAsDataURL(ev.target.files[index]);
				}
			}
		},
		createRequest () {
			let formData = new FormData();
			this.requests.forEach((v,k) => {
				formData.append(`request${k}`, v);
			});

			axios.post(
				`Request`, 
				formData, 
				{
					headers: {'Content-Type' : 'multipart/form-data'}
				}
			).then(response => {
				$('input#request').val('');
				this.requests = [];
				this.req_arr = response.data;
			}).catch(errors => {
				console.log(errors.response.data.message);
				this.notif = true; 
				this.notif_title = 'err';
				this.notif_text = errors.response.data.message;
				this.notif_status = errors.response.status;
			});
		},
		deleteRequest () {
			this.requests.forEach( (v, k) => {
				axios.delete(`Request/${v}`).then(response => {
					this.requests = [];
					this.req_arr = this.req_arr.filter( data => data.id != v);
				}).catch(errors => {
					this.errors = errors.response.data.errors;
				});
			})
		},
		createDiagnoses () {
			let formData = new FormData();
			this.diagnoses.forEach((v,k) => {
				formData.append(`request${k}`, v);
			});

			axios.post(
				`Diagnosis`, 
				formData, 
				{
					headers: {'Content-Type' : 'multipart/form-data'}
				}
			).then(response => {
				$('input#diagnosis').val('');
				this.diagnoses = [];
				this.diags_arr = response.data;
			}).catch(errors => {
				console.log(errors.response.data.message);
				this.notif = true; 
				this.notif_title = 'err';
				this.notif_text = errors.response.data.message;
				this.notif_status = errors.response.status;
			});
		},
		deleteDiagnoses () {
			this.diagnoses.forEach( (v, k) => {
				axios.delete(`Diagnosis/${v}`).then(response => {
					this.diagnoses = [];
					this.diags_arr = this.diags_arr.filter( data => data.id != v);
				}).catch(errors => {
					this.errors = errors.response.data.errors;
				});
			})
		},
		showImage (ev) {
			this.imageDialog = true; 
			this.selected_image = $(ev.target).attr('src');
		}
    }
}
</script>