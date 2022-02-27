<template>
    <div class="container-fluid">
        <div class="form-group">
            <div class="d-flex">
                <div class="form-group col-md-3 m-0">
                  <label for="skin">Skin</label>
                  <input type="text" name="skin" id="skin" class="form-control" placeholder="Aa..." v-model="exam.skin">
                  <span v-if="errors.skin" class="invalid-feedback" role="alert">
                    <strong>{{ errors.skin[0] }}</strong>
                  </span>
                </div>
                <div class="form-group col-md-3 m-0">
                  <label for="hair">Hair</label>
                  <input type="text" name="hair" id="hair" class="form-control" placeholder="Aa..." v-model="exam.hair">
				  <span v-if="errors.hair" class="invalid-feedback" role="alert">
                    <strong>{{ errors.hair[0] }}</strong>
                  </span>
                </div>
                <div class="form-group col-md-3 m-0">
                  <label for="nails">Nails</label>
                  <input type="text" name="nails" id="nails" class="form-control" placeholder="Aa..." v-model="exam.nails">
				  <span v-if="errors.nails" class="invalid-feedback" role="alert">
                    <strong>{{ errors.nails[0] }}</strong>
                  </span>
                </div>
                <div class="form-group col-md-3 m-0">
                  <label for="head">Head</label>
                  <input type="text" name="head" id="head" class="form-control" placeholder="Aa..." v-model="exam.head">
				  <span v-if="errors.head" class="invalid-feedback" role="alert">
                    <strong>{{ errors.head[0] }}</strong>
                  </span>
                </div>
            </div>
            <div class="d-flex">
                <div class="form-group col-md-3 m-0">
                  <label for="eyes">Eyes</label>
                  <input type="text" name="eyes" id="eyes" class="form-control" placeholder="Aa..." v-model="exam.eyes">
				  <span v-if="errors.eyes" class="invalid-feedback" role="alert">
                    <strong>{{ errors.eyes[0] }}</strong>
                  </span>
                </div>
                <div class="form-group col-md-3 m-0">
                  <label for="ears">Ears</label>
                  <input type="text" name="ears" id="ears" class="form-control" placeholder="Aa..." v-model="exam.ears">
				  <span v-if="errors.ears" class="invalid-feedback" role="alert">
                    <strong>{{ errors.ears[0] }}</strong>
                  </span>
                </div>
                <div class="form-group col-md-3 m-0">
                  <label for="nose">Nose</label>
                  <input type="text" name="nose" id="nose" class="form-control" placeholder="Aa..." v-model="exam.nose">
				  <span v-if="errors.nose" class="invalid-feedback" role="alert">
                    <strong>{{ errors.nose[0] }}</strong>
                  </span>
                </div>
                <div class="form-group col-md-3 m-0">
                  <label for="mouth">Mouth</label>
                  <input type="text" name="mouth" id="mouth" class="form-control" placeholder="Aa..." v-model="exam.mouth">
				  <span v-if="errors.mouth" class="invalid-feedback" role="alert">
                    <strong>{{ errors.mouth[0] }}</strong>
                  </span>
                </div>
            </div>
            <div class="d-flex">
                <div class="form-group col-md-3 m-0">
                  <label for="throat">Throat</label>
                  <input type="text" name="throat" id="throat" class="form-control" placeholder="Aa..." v-model="exam.throat">
				  <span v-if="errors.throat" class="invalid-feedback" role="alert">
                    <strong>{{ errors.throat[0] }}</strong>
                  </span>
                </div>
                <div class="form-group col-md-3 m-0">
                  <label for="neck">Neck</label>
                  <input type="text" name="neck" id="neck" class="form-control" placeholder="Aa..." v-model="exam.neck">
				  <span v-if="errors.neck" class="invalid-feedback" role="alert">
                    <strong>{{ errors.neck[0] }}</strong>
                  </span>
                </div>
                <div class="form-group col-md-3 m-0">
                  <label for="cl">Chest/Lungs</label>
                  <input type="text" name="cl" id="cl" class="form-control" placeholder="Aa..." v-model="exam.cl">
				  <span v-if="errors.cl" class="invalid-feedback" role="alert">
                    <strong>{{ errors.cl[0] }}</strong>
                  </span>
                </div>
                <div class="form-group col-md-3 m-0">
                  <label for="heart">Heart</label>
                  <input type="text" name="heart" id="heart" class="form-control" placeholder="Aa..." v-model="exam.heart">
				  <span v-if="errors.heart" class="invalid-feedback" role="alert">
                    <strong>{{ errors.heart[0] }}</strong>
                  </span>
                </div>
            </div>
            <div class="d-flex">
                <div class="form-group col-md-3 m-0">
                  <label for="abdomen">Abdomen</label>
                  <input type="text" name="abdomen" id="abdomen" class="form-control" placeholder="Aa..." v-model="exam.abdomen">
				  <span v-if="errors.abdomen" class="invalid-feedback" role="alert">
                    <strong>{{ errors.abdomen[0] }}</strong>
                  </span>
                </div>
                <div class="form-group col-md-3 m-0">
                  <label for="backnspine">Back and Spine</label>
                  <input type="text" name="backnspine" id="backnspine" class="form-control" placeholder="Aa..." v-model="exam.back">
				  <span v-if="errors.back" class="invalid-feedback" role="alert">
                    <strong>{{ errors.back[0] }}</strong>
                  </span>
                </div>
                <div class="form-group col-md-3 m-0">
                  <label for="ext">Extremities</label>
                  <input type="text" name="ext" id="ext" class="form-control" placeholder="Aa..." v-model="exam.ext">
				  <span v-if="errors.ext" class="invalid-feedback" role="alert">
                    <strong>{{ errors.ext[0] }}</strong>
                  </span>
                </div>
            </div>
            <div class="form-group col-md-12">
              <label for="impression">Impression</label>
              <input type="text" name="impression" id="impression" class="form-control" placeholder="Aa..." v-model="exam.impression">
              <span v-if="errors.impression" class="invalid-feedback" role="alert">
                <strong>{{ errors.impression[0] }}</strong>
              </span>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['exam','errs'],
    data () {
        return {
            errors: this.errs,
        }
    },
}
</script>