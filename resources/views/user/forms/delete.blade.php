<div>
    <form
    id="form-delete-user"
    ref="form-delete-user"
    method="POST"
    data-vv-scope="form-delete-user"
    autocomplete="off"
    >                            
        <div class="container py-3">
            <p>Tem certeza que deseja excluir?</p>
        </div>                    
        <input type="hidden" id="id" name="id" v-model="item.id"  /> 
    </form>   
</div>      
<template slot="modal-footer">

    <b-container fluid>
        <b-row class="mb-1">        
            <b-col>
                <b-btn
                    type="button"
                    v-b-modal.modal-footer-sm
                    class="float-right mx-1"
                    :variant="'danger'"
                    @click="$refs.users.deleteUser()"
                >
                        <i class="fas fa-trash"></i>
                        Excluir
                    </b-btn>

                    <b-btn
                    type="button"
                    v-b-modal.modal-footer-sm
                    class="float-right mx-1"
                    @click="$root.$emit('bv::hide::modal', 'delete', $event.target)"
                >
                    <i class="fas fa-times-circle"></i>
                    Cancelar
                </b-btn>
            </b-col>
        </b-row>

    </b-container>

</template>                           