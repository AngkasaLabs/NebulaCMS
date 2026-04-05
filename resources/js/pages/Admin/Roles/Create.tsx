import Form from './Form';

interface Permission {
    id: number;
    name: string;
    group: string;
}

interface Props {
    permissions: Permission[];
}

export default function Create({ permissions }: Props) {
    return <Form permissions={permissions} />;
}
