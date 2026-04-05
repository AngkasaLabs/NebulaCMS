import Form from './Form';

interface Permission {
    id: number;
    name: string;
    group: string;
}

interface Role {
    id: number;
    name: string;
    permissions: Permission[];
}

interface Props {
    role: Role;
    permissions: Permission[];
}

export default function Edit({ role, permissions }: Props) {
    return <Form role={role} permissions={permissions} />;
}
