import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';
import Form from './Form';

interface Props {
    tag: {
        id: number;
        name: string;
        description: string;
        color: string;
    };
}

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Tags',
        href: route('admin.tags.index'),
    },
    {
        title: 'Edit',
    },
];
export default function Create({ tag }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Edit Tag" />
            <div className="p-4">
                <Form tag={tag} />
            </div>
        </AppLayout>
    );
}
