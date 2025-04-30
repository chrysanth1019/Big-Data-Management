@extends('layouts.admin')

@section('title', '許可IPアドレス編集')

@section('content')
<div class="jp-fade-in">
    <div class="card mb-4">
        <div class="card-header bg-jp-primary text-white">
            <h5 class="mb-0">{{ $user->name }} - 許可IPアドレス編集</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update-allowed-ips', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="mb-4">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="allowed_ips" class="form-label fw-bold mb-md-0">
                                許可IPアドレス
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <textarea 
                                    id="allowed_ips" 
                                    name="allowed_ips" 
                                    class="form-control @error('allowed_ips') is-invalid @enderror" 
                                    rows="3"
                                    placeholder="例: 192.168.1.1, 10.0.0.1 (カンマ区切りで複数可能)&#10;空白の場合はすべてのIPを許可"
                                >{{ old('allowed_ips', $user->getAllowedIpsString()) }}</textarea>
                                @error('allowed_ips')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                複数のIPアドレスを許可する場合はカンマ（,）で区切ってください。<br>
                                空白の場合はすべてのIPアドレスからのアクセスを許可します。
                            </small>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <strong>注意:</strong> IPアドレス制限を設定すると、ユーザーは指定されたIPアドレスからのみアクセスできるようになります。
                    正確なIPアドレスを入力してください。
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-x-circle me-1"></i> キャンセル
                    </a>
                    <button type="submit" class="btn btn-jp-primary">
                        <i class="bi bi-check-circle me-1"></i> 保存
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection