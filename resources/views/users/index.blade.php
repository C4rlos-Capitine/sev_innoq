@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Gestão de Utilizadores</h1>
        <div>
            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm me-2">Voltar</a>
            <button id="btnNew" class="btn btn-primary btn-sm">Adicionar Utilizador</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th style="width:180px">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <button class="btnEdit btn btn-sm btn-outline-primary me-2">Editar</button>
                        <form method="POST" action="{{ route('users.destroy', $user) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Eliminar utilizador?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bootstrap Modal form (create / edit) -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="userModalLabel">Novo utilizador</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="userForm" method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="f_name" class="form-label">Nome</label>
                    <input type="text" class="form-control" name="name" id="f_name" required>
                </div>
                <div class="mb-3">
                    <label for="f_email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="f_email" required>
                </div>
                <div class="mb-3">
                    <label for="f_password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="f_password" autocomplete="new-password">
                </div>
                <div class="mb-3">
                    <label for="f_password_confirmation" class="form-label">Confirmar Password</label>
                    <input type="password" class="form-control" name="password_confirmation" id="f_password_confirmation" autocomplete="new-password">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
        // Requires Bootstrap JS loaded in layout
        const userModalEl = document.getElementById('userModal');
        const userModal = new bootstrap.Modal(userModalEl);
        const btnNew = document.getElementById('btnNew');
        const userForm = document.getElementById('userForm');
        const modalTitle = document.getElementById('userModalLabel');

        btnNew.addEventListener('click', ()=>{
            modalTitle.innerText = 'Novo utilizador';
            userForm.action = "{{ route('users.store') }}";
            // clear fields
            document.getElementById('f_name').value = '';
            document.getElementById('f_email').value = '';
            document.getElementById('f_password').value = '';
            document.getElementById('f_password_confirmation').value = '';
            // remove method input if present
            const method = userForm.querySelector('input[name="_method"]'); if (method) method.remove();
            userModal.show();
        });

        document.querySelectorAll('.btnEdit').forEach(btn=>{
            btn.addEventListener('click', (e)=>{
                const tr = e.target.closest('tr');
                const id = tr.getAttribute('data-id');
                const name = tr.getAttribute('data-name');
                const email = tr.getAttribute('data-email');

                modalTitle.innerText = 'Editar utilizador';
                userForm.action = `/users/${id}`;
                // set method to PUT
                let method = userForm.querySelector('input[name="_method"]');
                if (!method) {
                    method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    userForm.appendChild(method);
                }
                method.value = 'PUT';

                document.getElementById('f_name').value = name;
                document.getElementById('f_email').value = email;
                document.getElementById('f_password').value = '';
                document.getElementById('f_password_confirmation').value = '';
                userModal.show();
            });
        });
    </script>
</div>
@endsection
