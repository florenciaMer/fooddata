    {{--  select ingredientes para dinamico--}}

                    <div class="form-group m-2">
                        <label for="ingrediente_id{{$i}}" class="visually-hidden">Ingrediente</label>
                        <select id="ingrediente_id{{$i}}"
                                data-id="{{$i}}" name="ingrediente_id"
                                class="ingSelect p-2 form-control">
                            @foreach($ingredientes as $ingrediente)
                            <option value="{{ $ingrediente->ingrediente_id }}" @if(old('ingrediente_id', $recetaIte->ingrediente->ingrediente_id) == $ingrediente->ingrediente_id) selected @endif>{{ $ingrediente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group m-2">
                        <label for="unidad_id{{$i}}" class="visually-hidden"></label>
                        <input type="text" id="unidad_id{{$i}}" disabled name="unidad_id"
                               class="form-control @error('unidad_id') is-invalid @enderror"
                               value="{{ old('unidad_id', $recetaIte->ingrediente->unidad->nombre) }}"
                    </div>

                    <div class="form-group m-2 d-none-mobile">
                        <label for="precio{{$i}}" class="visually-hidden">Precio U.</label>
                        <input type="text" disabled id=precio{{$i}} name="precio" class="form-control text-center p-2 @error('precio') is-invalid @enderror"
                               value="{{ old('precio', $recetaIte->ingrediente->precio/100) }}.-"
                    </div>
                        <button title="Confirmar" class="btn btn-block btn-success mx-2 my-1"><ion-icon class="pointer-events" name="pencil-outline"></ion-icon></button>
                </form>


<script>
    window.addEventListener('DOMContentLoaded', function() {
        const ingSelect = document.querySelectorAll('.ingSelect');
        ingSelect.forEach(elem => (
            elem.addEventListener('change', function () {

                const id = this.dataset.id;
                const unidadInput = document.getElementById('unidad_id' + id);
                const xhr = new XMLHttpRequest();

                xhr.open('GET', '/app/generar_combo_unidades.php?i=' + this.value);
                xhr.addEventListener('readystatechange', function () {

                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            unidadInput.value = xhr.responseText;
                        }
                    }
                });
                xhr.send(null);
            }))
        )
        const ingSelect2 = document.querySelectorAll('.ingSelect');
        ingSelect2.forEach(elem => (
            elem.addEventListener('change', function () {

                const id = this.dataset.id;
                const precioInput = document.getElementById('precio' + id);
                const xhr = new XMLHttpRequest();
                xhr.open('GET', '/app/generar_combo_precios.php?ip=' + this.value);
                xhr.addEventListener('readystatechange', function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            precioInput.value =  xhr.responseText;
                        }
                    }
                });
                xhr.send(null);
            }))
        )
        const ingSelect3 = document.querySelectorAll('.ingSelect');
        ingSelect3.forEach(elem => (
            elem.addEventListener('change', function () {

                const id = this.dataset.id;
                const precioInputTot = document.getElementById('precio' + id);
                const xhr = new XMLHttpRequest();
                xhr.open('GET', '/app/generar_combo_precios.php?ip=' + this.value);
                xhr.addEventListener('readystatechange', function () {

                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            const tot = xhr.response * document.getElementById('cant' + id).value;
                            document.getElementById('precioTot' + id).value = '$' + tot;
                        }
                    }
                });
                xhr.send(null);
            }))
        )
</script>
