import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { ArrowLeft, Edit2, Mail, Shield, Calendar } from 'lucide-react';
import { format } from 'date-fns';
import { id } from 'date-fns/locale';

interface Role {
    id: number;
    name: string;
}

interface User {
    id: number;
    name: string;
    email: string;
    roles: Role[];
    bio: string | null;
    avatar: string | null;
    facebook_url: string | null;
    twitter_url: string | null;
    instagram_url: string | null;
    linkedin_url: string | null;
    created_at: string;
}

interface Props {
    user: User;
}

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Users',
        href: route('admin.users.index'),
    },
    {
        title: 'Detail',
    },
];

const roleColors: { [key: string]: string } = {
    admin: 'bg-red-500',
    editor: 'bg-blue-500',
    author: 'bg-green-500',
    user: 'bg-gray-500',
};

export default function Show({ user }: Props) {
    const socialLinks = [
        { url: user.facebook_url, icon: 'facebook.svg', label: 'Facebook' },
        { url: user.twitter_url, icon: 'twitter.svg', label: 'Twitter' },
        { url: user.instagram_url, icon: 'instagram.svg', label: 'Instagram' },
        { url: user.linkedin_url, icon: 'linkedin.svg', label: 'LinkedIn' },
    ].filter(link => link.url);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`User: ${user.name}`} />

            <div className="p-4 max-w-5xl mx-auto">
                {/* Header */}
                <div className="flex justify-between items-start mb-8">
                    <div>
                        <Link href="/users" className="inline-flex items-center text-gray-400 hover:text-gray-200 mb-4">
                            <ArrowLeft className="w-4 h-4 mr-2" />
                            Kembali ke daftar pengguna
                        </Link>
                    </div>

                    <Link href={`/users/${user.id}/edit`}>
                        <Button variant="outline" className="border-gray-700 text-gray-200 hover:bg-gray-800">
                            <Edit2 className="w-4 h-4 mr-2" />
                            Edit Pengguna
                        </Button>
                    </Link>
                </div>

                {/* Main Content */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {/* Left Column - Profile Info */}
                    <div className="md:col-span-1">
                        <div className="rounded-lg border border-gray-800 bg-[#0c1015] p-6">
                            <div className="flex flex-col items-center text-center mb-6">
                                {user.avatar ? (
                                    <img
                                        src={`/storage/${user.avatar}`}
                                        alt={user.name}
                                        className="h-32 w-32 rounded-full object-cover ring-4 ring-gray-800 mb-4"
                                    />
                                ) : (
                                    <div className="flex h-32 w-32 items-center justify-center rounded-full bg-gray-800 text-gray-200 text-4xl font-bold ring-4 ring-gray-700 mb-4">
                                        {user.name.charAt(0).toUpperCase()}
                                    </div>
                                )}
                                <h2 className="text-2xl font-bold text-gray-200 mb-1">{user.name}</h2>
                                <div className="flex items-center gap-2 text-gray-400 mb-4">
                                    <Mail className="w-4 h-4" />
                                    {user.email}
                                </div>
                                <div className="flex flex-wrap gap-2 justify-center">
                                    {user.roles.map((role) => (
                                        <Badge
                                            key={role.id}
                                            className={`${roleColors[role.name.toLowerCase()] || 'bg-gray-500'}`}
                                        >
                                            <Shield className="w-3 h-3 mr-1" />
                                            {role.name}
                                        </Badge>
                                    ))}
                                </div>
                            </div>

                            {user.bio && (
                                <div className="border-t border-gray-800 pt-4 mt-4">
                                    <h3 className="text-sm font-semibold text-gray-400 uppercase mb-2">Bio</h3>
                                    <p className="text-gray-200">{user.bio}</p>
                                </div>
                            )}

                            <div className="border-t border-gray-800 pt-4 mt-4">
                                <h3 className="text-sm font-semibold text-gray-400 uppercase mb-2">Info</h3>
                                <div className="space-y-2">
                                    <div className="flex items-center text-gray-200">
                                        <Calendar className="w-4 h-4 mr-2 text-gray-400" />
                                        Bergabung {format(new Date(user.created_at), 'dd MMMM yyyy', { locale: id })}
                                    </div>
                                </div>
                            </div>

                            {socialLinks.length > 0 && (
                                <div className="border-t border-gray-800 pt-4 mt-4">
                                    <h3 className="text-sm font-semibold text-gray-400 uppercase mb-2">Media Sosial</h3>
                                    <div className="flex flex-wrap gap-2">
                                        {socialLinks.map((link, index) => (
                                            <a
                                                key={index}
                                                href={link.url || '#'}
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                className="inline-flex items-center px-3 py-1 rounded-full bg-gray-800 text-gray-200 hover:bg-gray-700 transition-colors"
                                            >
                                                <img src={`/icons/${link.icon}`} alt={link.label} className="w-4 h-4 mr-2" />
                                                {link.label}
                                            </a>
                                        ))}
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>

                    {/* Right Column - Activity & Stats */}
                    <div className="md:col-span-2">
                        <div className="rounded-lg border border-gray-800 bg-[#0c1015] p-6">
                            <h3 className="text-xl font-semibold text-gray-200 mb-4">Aktivitas Terbaru</h3>
                            <div className="text-gray-400 text-center py-8">
                                Belum ada aktivitas untuk ditampilkan.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
